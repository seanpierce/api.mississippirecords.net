<?php

namespace App\Models\Submodels;

class OrderLineItem
{
	public $id;
	public $artist;
	public $title;
	public $cost;
	public $quantity_ordered;
	public $subtotal;

	public function __construct(array $payload)
	{
		$this->id = $payload['id'];
		$this->artist = $payload['artist'];
		$this->title = $payload['title'];
		$this->cost = $payload['cost'];
		$this->quantity_ordered = $payload['quantity_ordered'];
		$this->subtotal = $this->quantity_ordered * $this->cost;
	}
}