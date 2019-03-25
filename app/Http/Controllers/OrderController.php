<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

use App\Models\Item as Item;
use App\Models\Order as Order;
use App\Models\SubModels\OrderLineItem as OrderLineItem;
use App\Models\SubModels\OrderConfirmationItem as OrderConfirmationItem;

class OrderController extends Controller
{
	private $auth;
	private $mailer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->auth = new AuthController;
		$this->mailer = new EmailController;
	}

	public function get_orders(Request $request)
	{
		$this->auth->allow_admin($request);

		$orders = Order::orderBy('created_at', 'DESC')->get();

		return response(json_encode($orders), 200)
			->header('Content-Type', 'json');
	}
	
	public function confirm_order_details(Request $request) 
	{
		$this->validate($request, OrderValidation::confirm_order);
		
		// get items
		$ids = array_count_values($request->ids);
		$items = Item::whereIn('id', $request->ids)
			->orderBy('artist', 'asc')
			->get();

		$total = 0;
		$output = [];

		// get totals
		foreach ($items as $item)
		{
			$order_confirmation_item = new OrderConfirmationItem;
			$order_confirmation_item->id = $item->id;
			$order_confirmation_item->artist = $item->artist;
			$order_confirmation_item->title = $item->title;
			$order_confirmation_item->cost = $request->b2b ? $item->b2b_cost : $item->basic_cost;
			$order_confirmation_item->quantity_available = $item->quantity_available;
			$order_confirmation_item->quantity_ordered = $ids["$item->id"];
			$order_confirmation_item->available = ($order_confirmation_item->quantity_ordered < $order_confirmation_item->quantity_available);
			$order_confirmation_item->subtotal = $order_confirmation_item->cost * $order_confirmation_item->quantity_ordered;

			array_push($output, $order_confirmation_item);
			$total += $order_confirmation_item->subtotal;
		}

		$response = new \stdClass();
		$response->items = $output;
		$response->total = $total;

		return response(json_encode($response), 200)
			->header('Content-Type', 'json');
	}

	public function get_stripe_details(Request $request) 
	{
		$this->auth->allow_admin($request);

		$key = env('STRIPE_SK');
		\Stripe\Stripe::setApiKey($key);

		$order = \Stripe\Charge::retrieve($request->StripeTransactionId);
		return response(json_encode($order), 200)
			->header('Content-Type', 'json');
	}

	public function mark_shipped(Request $request)
	{
		$this->auth->allow_admin($request);

		$id = $request->id;
		$order = Order::findOrFail($id);

		$order->shipped = true;
		$order->tracking_number = $request->tracking_number;

		$order->save();

		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
	}

	public function make_payment(Request $request)
	{
		$this->validate($request, OrderValidation::make_payment);

		$line_item_details = $this->get_line_item_details($request->line_item_details);

		// create a new order from the request
		$order = new Order;
		$order->customer_name = $request->name;
		$order->email = $request->email;
		$order->order_number = $order->generate_order_number();
		$order->line_item_details = json_encode($line_item_details);
		$order->shipping_address = $request->shipping_address;
		$order->shipping_city = $request->shipping_city;
		$order->shipping_state = $request->shipping_state;
		$order->shipping_zip = $request->shipping_zip;
		$order->order_total = $request->order_total;
		$order->shipping_total = $request->shipping_total;
		$order->tax = $request->tax;
		$order->class = $request->b2b ? 'b2b' : 'direct';
		
		$key = env('STRIPE_SK');
		\Stripe\Stripe::setApiKey($key);

		$stripe_details = [
			'amount' => $order->order_total,
			'currency' => 'usd',
			'description' => "Order: $order->order_number | Customer: $order->customer_name",
			'source' => $request->stripe_token,
			'receipt_email' => $order->email,
			'metadata' => ['order_number' => $order->order_number],
			'metadata' => ['customer_name' => $order->customer_name],
			'metadata' => ['customer_email' => $order->customer_email],
		];

		$charge = \Stripe\Charge::create($stripe_details);

		$success = $charge['paid'] === true;
	
		if (!$success)
			abort(401, 'Unable to process payment');

		// update order record to include stripe transaction ID
		$order->stripe_transaction_id = $charge['id'];
		// save the order
		$order->save();

		// decrement stock
		$this->decrement_stock($line_item_details);

		// // send order confirmation email
		$email_parameters = [
			'name' => $request->name,
			'email' => $request->email,
			'order_number' => $order->order_number,
			'line_item_details' => $line_item_details,
			'order_total' => $request->order_total,
			'shipping_total' => $request->shipping_total,
			'tax' => $request->tax,
		];

		$this->mailer->send_order_confirmation_email($email_parameters);

		return response(json_encode($order->order_number), 200)
			->header('Content-Type', 'json');
	}

	public function request_international_order(Request $request)
	{
		$this->validate($request, OrderValidation::request_international_order);
		
		$order_total = array_sum(array_column($request->items, 'subtotal'));

		$email_parameters = [
			'name' => $request->name,
			'email' => $request->email,
			'items' => $request->items,
			'order_total' => $order_total
		];

		$this->mailer->send_international_order_request_to_admin($email_parameters);
		$this->mailer->send_international_order_email_to_customer($email_parameters);

		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
	}

	private function decrement_stock($line_item_details)
	{
		foreach ($line_item_details as $line_item)
		{
			$item = Item::findOrFail($line_item->id);
			$quantity_ordered = $line_item->quantity_ordered;
			$item->quantity_available = $item->quantity_available - $quantity_ordered;
			$item->save();
		}
	}

	private function get_line_item_details($details)
	{
		$output = [];
		foreach ($details as $detail) 
		{
			array_push($output, new OrderLineItem($detail));
		};
		return $output;
	}
}

abstract class OrderValidation
{
	const make_payment = [
		'name' => 'required',
		'email' => 'required',
		'line_item_details' => 'required',
		'shipping_address' => 'required',
		'shipping_city' => 'required',
		'shipping_state' => 'required',
		'shipping_zip' => 'required',
		'order_total' => 'required',
		'shipping_total' => 'required',
		'tax' => 'required',
		'card' => 'required',
		'stripe_token' => 'required',
	];

	const confirm_order = [
		'ids' => 'required',
	];

	const request_international_order = [
		'name' => 'required',
		'email' => 'required',
		'items' => 'required',
	];
}
