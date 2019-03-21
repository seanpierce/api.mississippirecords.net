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
	private $debug;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->email_headers = 'MIME-Version: 1.0'
        . "\n" . 'Content-type: text/html; charset=iso-8859-1'
        . "\n" . 'From: Mississippi Records<noreply@mississippirecords.net>'
		. "\n";
		
		$this->validator = new CustomValidator;
		$this->helpers = new CustomHelpers;
		$this->debug = env('APP_DEBUG', true);
	}
	
	public function send_order_confirmation_email($email_parameters)
	{
		//
	}

	public function send_order_shipped_email($email_parameters)
	{
		//
	}

	public function send_new_member_request_email($email_parameters)
	{
		$this->validator->validate_pressence($email_parameters, [
			'name', 
			'email',
		]);

		$template = view('email/b2b_member_request_confirmation', $email_parameters);
		$email = $this->build($template);
		$subject = $this->debug ?
			"[Test] Thanks for requesting a B2B membership" :
			"Thanks for requesting a B2B membership";

		LOG::info("send_new_member_request_email sent to {$email_parameters['email']}");
		mail($email_parameters['email'], $subject, $email, $this->email_headers);
	}

	public function send_approved_b2b_member_request_email($email_parameters)
	{
		$this->validator->validate_pressence($email_parameters, [
			'name', 
			'email',
		]);

		$template = view('email/b2b_member_approved', $email_parameters);
		$email = $this->build($template);
		$subject = $this->debug ?
			"[Test] Account request approved" :
			"Account request approved";

		LOG::info("send_approved_b2b_member_request_email sent to {$email_parameters['email']}");
		mail($email_parameters['email'], $subject, $email, $this->email_headers);
	}

	public function send_international_order_request_to_admin($email_parameters)
	{
		$this->validator->validate_pressence($email_parameters, [
			'name',
			'email',
			'items',
			'order_total',
		]);

		$email_parameters['helpers'] = $this->helpers;

		$template = view('email/request_international_order_admin', $email_parameters);
		$email = $this->build($template);
		$subject = $this->debug ?
			"[Test] Someone has requested to place a new international order" :
			"Thanks Someone has requested to place a new international order";

		LOG::info("send_international_order_request_to_admin sent to {$email_parameters['email']}");
		mail('orders@mississippirecords.net', $subject, $email, $this->email_headers);
	}
	
	public function send_international_order_email_to_customer($email_parameters) 
    {
		$this->validator->validate_pressence($email_parameters, [
			'name',
			'email',
			'items',
			'order_total',
		]);

		$email_parameters['helpers'] = $this->helpers;

		$template = view('email/request_international_order', $email_parameters);
		$email = $this->build($template);
		$subject = $this->debug ?
			"[Test] Thanks for requesting to place an international order" :
			"Thanks for requesting to place an international order";

		LOG::info("send_international_order_email_to_customer sent to {$email_parameters['email']}");
		mail($email_parameters['email'], $subject, $email, $this->email_headers);
	}
	
	private function build($template)
	{
		$header = view('email/partials/header', []);
		$footer = view('email/partials/footer', []);

		return $header . $template . $footer;
	}
}
