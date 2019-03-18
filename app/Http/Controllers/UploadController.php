<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as User;
use App\Models\PasswordHash as PasswordHash;
use App\Models\Token as Token;
use Mockery\CountValidator\Exception;

class UploadController extends Controller
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
	
	public function upload_file(Request $request)
	{
		$this->auth->allow_admin($request);
		
		$files = $_FILES;

		foreach ($files as $file)
		{
			$temp = $file['tmp_name'];
			$name = $file['name'];
			$path = 'uploads/' . basename($name);
			move_uploaded_file($temp, $path);
		}
			
		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
	}
}
