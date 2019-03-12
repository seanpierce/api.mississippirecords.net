<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeaturedItem as FeaturedItem;
use App\Models\Item as Item;
use Illuminate\Http\Response;

class FeaturedItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAll() 
    {
		$featured_items= FeaturedItem::all();
		$ids = [];
		foreach ($featured_items as $featured_item) {
			array_push($ids, $featured_item->item_id);
		}

		$items = Item::whereIn('id', $ids)->get();
		return response($items, 200)
			->header('Content-Type', 'json');
    }

    public function create(Request $request)
    {
        FeaturedItem::create(array_merge($request->all(), ['index' => 'value']));
		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
	}
	
	public function delete($id)
    {
		$item = FeaturedItem::where('item_id', $id)->first();
		$item->delete();
		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
    }
}
