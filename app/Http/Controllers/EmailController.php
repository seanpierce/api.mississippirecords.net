<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use App\Models\B2BMemberRequest as B2BMemberRequest;
use App\Models\User as B2BMember;
use App\Helpers\CustomValidator as CustomValidator;
use App\Helpers\CustomHelpers as CustomHelpers;

class EmailController extends Controller
{
	private $email_headers;
	private $validator;
	private $helpers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->email_headers = 'MIME-Version: 1.0'
        . "\n" . 'Content-type: text/html; charset=iso-8859-1'
        . "\n" . 'From: Sean\'s Test<noreply@test.com>'
        . "\n";
	}
	
	public function send_order_confirmation_email()
	{
		//
	}

	public function send_new_member_request_email(B2BMemberRequest $b2b_member_request)
	{
		//
	}

	public function send_approved_b2b_member_request_email(B2BMember $b2b_member)
	{
		//
	}
	
	public function send_international_order_email(Request $request) 
    {
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required'
		]);

		$this->validate($request->items, [
			'name' => 'required',
			'email' => 'required'
		]);

		$template = view('email/send', ['title' => $request->title, 'content' => $request->content]);
		$email = $this->build($template);

		// mail(to, subject, body, headers);
        mail('sumler.sean@gmail.com', 'A new test!!!', $email, $this->email_headers);

        return response(json_encode(true), 200)
            ->header('Content-Type', 'json');
	}
	
	private function build($template)
	{
		$header = view('email/partials/header', []);
		$footer = view('email/partials/footer', []);

		return $header . $template . $footer;
	}
}
