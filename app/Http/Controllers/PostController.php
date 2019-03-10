<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post as Post;

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

    public function get_page_posts($page_name)
    {
        $posts = Item::where('name', $page_name)->get();
		return response($posts, 200)
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
