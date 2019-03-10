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
		return response($item, 200)
			->header('Content-Type', 'json');
    }

    public function getAll() 
    {
        $items = Item::all();
		return response($items, 200)
			->header('Content-Type', 'json');
    }

    public function create(Request $request)
    {
		$this->auth->allow_admin($request);
        
        Item::create(array_merge($request->all(), ['index' => 'value']));
		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
	}
	
	public function update(Request $request)
    {
		$this->auth->allow_admin($request);

		$id = $request->id;
		$item = Item::findOrFail($id);
		$item->update(array_merge($request->all(), ['index' => 'value']));
		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
	}
	
	public function delete($id)
    {
        $this->auth->allow_admin($request);

		$item = Item::findOrFail($id);
		$item->delete();
		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
    }
}
