<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedItem extends Model
{
	protected $guarded = ['id'];
    protected $fillable = [
		'item_id'
	];
}