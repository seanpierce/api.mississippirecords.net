<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item as Item;
use App\Models\Order as Order;

class OrderController extends Controller
{
	private $auth;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->auth = new AuthController;
	}

	public function get_orders(Request $request)
	{
		$this->auth->auth_admin($request);

		$orders = Order::orderBy('created_at', 'DESC')->get();

		return response(json_encode($orders), 200)
			->header('Content-Type', 'json');
	}
	
	public function confirm_order_details(Request $request) 
	{	
		$b2b = $request->b2b;
		
		// get items
		$ids = array_count_values($request->ids);
		$items = Item::whereIn('id', $request->ids)->get();

		$total = 0;
		$output = [];

		// get totals
		foreach ($items as $item)
		{
			$order_confirmation_item = new OrderConfirmationItem;
			$order_confirmation_item->id = $item->id;
			$order_confirmation_item->artist = $item->artist;
			$order_confirmation_item->title = $item->title;
			$order_confirmation_item->cost = $b2b ? $item->b2b_cost : $item->basic_cost;
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
		$this->auth->auth_admin($request);

		$key = config('STRIPE_SECRET_KEY');
		\Stripe\Stripe::setApiKey($key);

		$order = \Stripe\Charge::retrieve($request->StripeTransactionId);
		return response(json_encode($order), 200)
			->header('Content-Type', 'json');
	}

	public function mark_shipped(Request $request)
	{
		$this->auth->auth_admin($request);

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
		$this->validate($request, [
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
			'cc_number' => 'required',
			'stripe_token' => 'required',
		]);

		// create a new order from the request and save it
		$order = new Order;
		$order->customer_name = $request->name;
		$order->email = $request->email;
		$order->order_number = $order->generate_order_number();
		$order->line_item_details = $order->get_line_item_details($request->line_item_details);
		$order->shipping_address = $request->shipping_address;
		$order->shipping_city = $request->shipping_city;
		$order->shipping_state = $request->shipping_state;
		$order->shipping_zip = $request->shipping_zip;
		$order->order_total = $request->order_total;
		$order->shipping_total = $request->shipping_total;
		$order->tax = $request->tax;
		$order->class = $request->b2b ? 'b2b' : 'direct';
		
		$key = config('STRIPE_SECRET_KEY');
		\Stripe\Stripe::setApiKey($key);

		$charge = \Stripe\Charge::create([
			'amount' => $xxx,
			'currency' => 'usd',
			'description' => "Order: $order->order_number | Customer: $order->customer_name",
			'source' => $xxx->token,
			'receipt_email' => $xxx->email,
		]);

		$paid = $charge['paid'] === true;
	
		if (!$paid) {
			return response(json_encode(false), 401)
				->header('Content-Type', 'json');
		}

		// update order record to include stripe transaction ID

		// decrement stock

		// send order confirmation email
	}
}

class OrderConfirmationItem
{
	public $id;
	public $artist;
	public $title;
	public $cost;
	public $subtotal;
	public $quantity_ordered;
	public $quantity_available;
	public $available;
}
