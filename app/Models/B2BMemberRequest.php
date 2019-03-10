<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class B2BMemberRequest extends Model
{
	protected $table = 'b2b_member_requests';
	protected $guarded = ['id'];
    protected $fillable = [
		'email', 
		'name',
		'password_hash',
		'shipping_address',
		'shipping_city',
		'shipping_state',
		'shipping_zip',
		'business_name',
	];
}