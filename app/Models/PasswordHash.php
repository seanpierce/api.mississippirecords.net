<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordHash extends Model
{
	protected $guarded = ['id'];
    protected $fillable = [
		'user_id', 
		'password_hash'
	];
}