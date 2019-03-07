<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $guarded = ['id'];
    protected $fillable = [
		'customer_name',
		'order_number',
		'tracking_number',
		'stripe_transaction_id',
		'order_date',
		'line_item_details',
		'shipping_cost',
		'shipping_address',
		'shipping_city',
		'shipping_state',
		'shipping_zip',
		'order_total',
		'paid',
		'shipped',
		'class',
	];
}