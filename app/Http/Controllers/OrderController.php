<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item as Item;

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

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
		$key = config('STRIPE_SECRET_KEY');
		\Stripe\Stripe::setApiKey($key);

		$order = \Stripe\Charge::retrieve($request->StripeTransactionId);
		return response(json_encode($order), 200)
			->header('Content-Type', 'json');
   }
}
