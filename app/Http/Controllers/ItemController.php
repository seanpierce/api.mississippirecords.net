<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item as Item;

class ItemController extends Controller
{
    private $auth;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->auth = new AuthController;
    }

    public function getById($id)
    {
		$item = Item::findOrFail($id);
		$item->images = explode("||", $item->images);

		return response($item, 200)
			->header('Content-Type', 'json');
    }

    public function getAll() 
    {
		$items = Item::all();
		
		foreach ($items as $item)
			$item->images = explode("||", $item->images);

		return response($items, 200)
			->header('Content-Type', 'json');
    }

    public function create(Request $request)
    {
		$this->auth->allow_admin($request);
		$this->validate($request, ItemValidation::item);

		$item = new Item;
        
		$item->artist = $request->artist;
		$item->title = $request->title;
		$item->description = $request->description;
		$item->basic_cost = $request->basic_cost * 100;
		$item->b2b_cost = $request->b2b_cost * 100;
		$item->images = implode("||", $request->images);
		$item->audio = $request->audio || '';
		$item->quantity_available = $request->quantity_available;
		$item->catalog = $request->catalog;
		$item->category = $request->category;
		$item->presale = $request->presale;
		$item->b2b_enabled = $request->b2b_enabled;
		$item->direct_enabled = $request->direct_enabled;

		$item->save();
		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
	}
	
	public function update(Request $request)
    {
		$this->auth->allow_admin($request);
		$this->validate($request, ItemValidation::item);

		$id = $request->id;
		$item = Item::findOrFail($id);

		$item->artist = $request->artist;
		$item->title = $request->title;
		$item->description = $request->description;
		$item->basic_cost = $request->basic_cost;
		$item->b2b_cost = $request->b2b_cost;
		$item->images = implode("||", $request->images);
		$item->audio = $request->audio;
		$item->quantity_available = $request->quantity_available;
		$item->catalog = $request->catalog;
		$item->category = $request->category;
		$item->presale = $request->presale;
		$item->b2b_enabled = $request->b2b_enabled;
		$item->direct_enabled = $request->direct_enabled;

		$item->save();
		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
	}
	
	public function delete(Request $request, $id)
    {
        $this->auth->allow_admin($request);

		$item = Item::findOrFail($id);
		$item->delete();
		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
	}
}

abstract class ItemValidation
{
	const item = [
		'artist' => 'required', 
		'title' => 'required',
		'description' => 'required',
		'basic_cost' => 'required',
		'b2b_cost' => 'required',
		'images' => 'required',
		// 'audio' => 'required',
		'quantity_available' => 'required',
		'catalog' => 'required',
		'category' => 'required',
		'presale' => 'required',
		'b2b_enabled' => 'required',
		'direct_enabled' => 'required'
	];
}
