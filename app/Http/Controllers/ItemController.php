<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        // return Item::findOrFail($id);
        return 'item ' . $id;
    }

    public function getAll() 
    {
        $results = app('db')->select("SELECT * FROM items");
        return json_encode($results);
    }

    public function create(Request $request)
    {
        $name = $request->input('name');
        return $name;
    }
}
