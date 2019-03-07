<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $guarded = ['id'];
    protected $fillable = [
		'customer_name',
		'email',
		'order_number',
		'tracking_number',
		'stripe_transaction_id',
		'line_item_details',
		'shipping_address',
		'shipping_city',
		'shipping_state',
		'shipping_zip',
		'order_total',
		'shipping_total',
		'tax',
		'paid',
		'shipped',
		'class',
	];

	public function __construct() 
	{
		$this->tracking_number = '';
		$this->stripe_transaction_id = '';
		$this->paid = false;
		$this->shipped = false;
	}

	public function get_line_item_details($details)
	{
		return $details;
	}

	public function generate_order_number()
	{
		return strtoupper(bin2hex(random_bytes(6)));
	}
}