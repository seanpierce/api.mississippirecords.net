<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item as Item;

class ItemController extends Controller
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

    public function getById($id)
    {
        $item = Item::find($id);
        return json_encode($item);
    }

    public function getAll() 
    {
        $results = Item::all();
        return json_encode($results);
    }

    public function create(Request $request)
    {
        Item::create(array_merge($request->all(), ['index' => 'value']));
        return json_encode(true);
    }
}
