<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $guarded = ['id'];
    protected $fillable = [
		'email', 
		'name',
		'class',
		'shipping_address',
		'shipping_city',
		'shipping_state',
		'shipping_zip',
		'business_name',
		'approved_date'
	];
}