<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token as Token;
use App\Models\User as B2BMember;

class B2BMemberController extends Controller
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
	
   public function get_b2b_member_address(Request $request) 
   {	
		$this->auth->allow_b2b($request);
		
		// get token from header
        $token_header = $request->header('token');
        
        if (!$token_header)
            abort(404, 'Token not present in the request.');
        
        // get token from db
        $token = Token::where('token', $token_header)->first();

        if (!$token)
            abort(404, 'Token not found.');

        // get b2b member from db
		$b2b_member = B2BMember::where('id', $token->user_id)->first();
		
		if (!$b2b_member)
			abort(404, 'User not found.');
			
		$address = new \stdClass();
		$address->shipping_address = $b2b_member->shipping_address;
		$address->shipping_city = $b2b_member->shipping_city;
		$address->shipping_state = $b2b_member->shipping_state;
		$address->shipping_zip = $b2b_member->shipping_zip;

		return response(json_encode($address), 200)
			->header('Content-Type', 'json');
   }

}

abstract class B2BMemberValidation
{
}
