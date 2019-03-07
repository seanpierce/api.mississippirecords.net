<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as User;
use App\Models\PasswordHash as PasswordHash;
use Mockery\CountValidator\Exception;

class UserController extends Controller
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
	
   public function get_user(Request $request) 
   {	
		$id = $request->id;
		$user = User::findOrFail($id);
		return response(json_encode($user), 200)
			->header('Content-Type', 'json');
   }

   public function login(Request $request)
   {
		// get user by email
		$user = User::where('email', $request->email)->first();

		if (!$user) {
			throw Exception("User not found");
		}

		// get user's password_hash
		$hash = PasswordHash::where('user_id', $user->id)->first();

		if (!$hash) {
			throw Exception("User not found");
		}

		// verify password
		if (password_verify($request->password, $hash)) {
			// login success
			// create and store token

			// return data to f/e with token
			return response(json_encode(true), 200)
				->header('Content-Type', 'json');
		} else {
			// login fail
			$response['input'] = $request->password;
			$response['hash'] = $hash;
			return response(json_encode($response), 401)
				->header('Content-Type', 'json'); 
		}
   }
}
