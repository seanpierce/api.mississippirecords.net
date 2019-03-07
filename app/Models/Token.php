<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
	protected $guarded = ['id'];
    protected $fillable = [
		'user_id', 
		'token'
	];

	public function generate($id)
	{
		$this->user_id = $id;
		$this->token = bin2hex(random_bytes(16)) . "-" . time();
	}
}