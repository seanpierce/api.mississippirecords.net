<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as User;
use App\Models\Token as Token;

class AuthController extends Controller
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

    public function allow_admin(Request $request)
    {
        // get token from header
        $token_header = $request->header('token');
        
        if (!$token_header)
            abort(403, 'Unauthorized action.');
        
        // get token from db
        $token = Token::where('token', $token_header)->first();

        if (!$token)
            abort(403, 'Unauthorized action.');

        // get user from db
        $user = User::where('id', $token->user_id)->first();

        if (!$user)
            abort(403, 'Unauthorized action.');

        // is user class ADMIN?
        $is_admin = $user->class == 'ADMIN';

        if (!$is_admin)
            abort(403, 'Unauthorized action.');
	}
	
	public function allow_b2b(Request $request)
    {
        // get token from header
        $token_header = $request->header('token');
        
        if (!$token_header)
            abort(403, 'Unauthorized action.');
        
        // get token from db
        $token = Token::where('token', $token_header)->first();

        if (!$token)
            abort(403, 'Unauthorized action.');

        // get user from db
        $user = User::where('id', $token->user_id)->first();

        if (!$user)
            abort(403, 'Unauthorized action.');

        // is user class ADMIN or B2B?
		$is_admin = $user->class == 'ADMIN';
		$is_b2b = $user->class == 'B2B';

        if (!$is_admin && !$is_b2b)
            abort(403, 'Unauthorized action.');
    }
}
