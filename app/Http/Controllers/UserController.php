<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as User;
use App\Models\PasswordHash as PasswordHash;
use App\Models\Token as Token;
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
		$this->validate($request, LoginValidation::login);

		// get user by email
		$user = User::where('email', $request->email)->first();

		if (!$user)
			abort(401, 'Invalid email address');

		// get user's password_hash
		$hash = PasswordHash::where('user_id', $user->id)->first();
		if (!$hash)
			abort(401, 'Invalid credentials');

		// verify password
		if (password_verify($request->password, $hash->password_hash)) {
			// login success
			// create and store token
			$token = Token::where('user_id', $user->id)->first();

			if (!$token)
				$token = new Token;

			$token->token = $this->generate_token();
			$token->user_id = $user->id;
			$token->save();

			// return data to f/e with token
			$login_response = $this->login_response($user, $token);

			return response(json_encode($login_response), 200)
				->header('Content-Type', 'json');
		} else {
			// login fail
			abort(401, 'Invalid credentials');
		}
   	}

	private function login_response(User $user, Token $token)
	{
		$response['name'] = $user->name;
		$response['email'] = $user->email;
		$response['token'] = $token->token;

		return $response;
	}

	private function generate_token() 
	{
	   return bin2hex(random_bytes(16)) . "-" . time();
   	}
}

abstract class LoginValidation
{
	const login = [
		'email' => 'required',
		'password' => 'required',
	];
}
