<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	protected $guarded = ['id'];
    protected $fillable = [
		'artist', 
		'title',
		'description',
		'basic_cost',
		'b2b_cost',
		'images',
		'audio',
		'quantity_available',
		'catalog',
		'category',
		'presale',
		'b2b_enabled',
		'direct_enabled'
	];
}