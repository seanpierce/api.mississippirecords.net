<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends Controller
{
	private $email_headers;
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
