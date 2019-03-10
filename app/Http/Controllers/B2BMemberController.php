<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token as Token;
use App\Models\User as B2BMember;
use App\Models\B2BMemberRequest as B2BMemberRequest;

class B2BMemberController extends Controller
{
	private $auth;
	private $emailer;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->auth = new AuthController;
		$this->emailer = new EmailController;
	}

	public function get_b2b_members(Request $request)
	{
		$this->auth->allow_admin($request);

		$members = B2BMember::where('class', 'B2B')->get();
		return response(json_encode($members), 200)
			->header('Content-Type', 'json');
	}

	public function delete_b2b_member(Request $request)
	{
		$this->validate($request, B2BMemberValidation::delete_b2b_member);
		$this->auth->allow_admin($request);

		$b2b_member = B2BMember::findOrFail($request->id);
		$b2b_member->delete();
		
		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
	}

	public function create_b2b_member_request(Request $request)
	{
		$this->validate($request, B2BMemberValidation::create_new_b2b_member_request);

		$b2b_member_request = new B2BMemberRequest(array_merge($request->all(), ['index' => 'value']));
		$b2b_member_request->password_hash = password_hash($request->password_hash, PASSWORD_BCRYPT);
		$b2b_member_request->save();

		// send new member request email
		$this->emailer->send_new_member_request_email($b2b_member_request);

		return response(json_encode(true), 200)
			->header('Content-Type', 'json');
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
	const create_new_b2b_member_request = [
		'name' => 'required', 
		'email' => 'required|unique:users,email',
		'password_hash' => 'required',
		'shipping_address' => 'required',
		'shipping_city' => 'required',
		'shipping_state' => 'required',
		'shipping_zip' => 'required',
		'business_name' => 'required',
	];

	const delete_b2b_member = [
		'id' => 'required',
	];
}
