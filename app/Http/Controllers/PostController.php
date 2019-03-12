<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post as Post;

class PostController extends Controller
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
        $posts = Post::where('page', $page_name)->get();
		return response($posts, 200)
			->header('Content-Type', 'json');
	}
	
	public function create_post(Request $request)
	{
		$this->auth->allow_admin($request);
		$this->validate($request, PostValidation::create_post);

		Post::create(array_merge($request->all(), ['index' => 'value']));

		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
	}

	public function update_post(Request $request)
	{
		$this->auth->allow_admin($request);
		$this->validate($request, PostValidation::update_post);

		$id = $request->id;
		$post = Post::findOrFail($id);
		$post->update(array_merge($request->all(), ['index' => 'value']));

		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
	}

	public function delete_post(Request $request)
	{
		$this->auth->allow_admin($request);
		$this->validate($request, PostValidation::delete_post);

		$id = $request->id;
		$post = Post::findOrFail($id);
		$post->delete();

		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
	}

}

abstract class PostValidation
{
	const create_post = [
		'page' => 'required',
		'text' => 'required',
	];

	const update_post = [
		'id' => 'required',
		'page' => 'required',
		'text' => 'required',
	];

	const delete_post = [
		'id' => 'required',
	];
}
