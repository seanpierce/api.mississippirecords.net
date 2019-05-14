<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use App\Models\B2BMemberRequest as B2BMemberRequest;
use App\Models\User as B2BMember;
use App\Helpers\CustomValidator as CustomValidator;
use App\Helpers\CustomHelpers as CustomHelpers;
use PHPUnit\Framework\MockObject\Stub\Exception;

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
        $this->validator->validate_pressence($email_parameters, [
            'name',
            'email',
            'order_number',
            'line_item_details',
            'order_total',
            'shipping_total',
            'tax',
        ]);

        $email_parameters['helpers'] = $this->helpers;

        $template = view('email/order_confirmation', $email_parameters);
        $body = $this->build($template);
        $subject = $this->debug ?
            "[Test] Mississippi Records - Order placed: {$email_parameters['order_number']}" :
            "Mississippi Records - Order placed: {$email_parameters['order_number']}";

        $this->send_mail($email_parameters, $subject, $body);
	}

	public function send_order_shipped_email($email_parameters)
	{
        $this->validator->validate_pressence($email_parameters, [
            'email',
            'order_number',
            'tracking_number'
        ]);

        $template = view('email/order_shipped', $email_parameters);
        $body = $this->build($template);
        $subject = $this->debug ?
            "[Test] You order has been shipped!" :
            "You order has been shipped!";

        $this->send_mail($email_parameters, $subject, $body);
	}

	public function send_new_member_request_email($email_parameters)
	{
		$this->validator->validate_pressence($email_parameters, [
			'name',
			'email',
		]);

		$template = view('email/b2b_member_request_confirmation', $email_parameters);
		$body = $this->build($template);
		$subject = $this->debug ?
			"[Test] Thanks for requesting a B2B membership" :
			"Thanks for requesting a B2B membership";

        $this->send_mail($email_parameters, $subject, $body);
	}

	public function send_approved_b2b_member_request_email($email_parameters)
	{
		$this->validator->validate_pressence($email_parameters, [
			'name',
			'email',
		]);

		$template = view('email/b2b_member_approved', $email_parameters);
		$body = $this->build($template);
		$subject = $this->debug ?
			"[Test] Account request approved" :
			"Account request approved";

        $this->send_mail($email_parameters, $subject, $body);
	}

	public function send_international_order_request_to_admin($email_parameters)
	{
		Log::info($email_parameters);
		$this->validator->validate_pressence($email_parameters, [
			'name',
			'email',
			'items',
			'order_total',
		]);

		$email_parameters['helpers'] = $this->helpers;

		$template = view('email/request_international_order_admin', $email_parameters);
		$body = $this->build($template);
		$subject = $this->debug ?
			"[Test] Someone has requested to place a new international order" :
			"Thanks Someone has requested to place a new international order";

        $this->send_mail($email_parameters, $subject, $body, env('ORDERS_TO_EMAIL'));
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
		$body = $this->build($template);
		$subject = $this->debug ?
			"[Test] Thanks for requesting to place an international order" :
			"Thanks for requesting to place an international order";

        $this->send_mail($email_parameters, $subject, $body);
	}

	private function build($template)
	{
		$header = view('email/partials/header', []);
		$footer = view('email/partials/footer', []);

		return $header . $template . $footer;
    }

    private function send_mail($email_parameters, $subject, $email, $override_to_address = null)
    {
        try
        {
            if ($override_to_address) {
                mail($override_to_address, $subject, $email, $this->email_headers);
                LOG::info("'$subject' sent to $override_to_address");
            } else {
                mail($email_parameters['email'], $subject, $email, $this->email_headers);
                LOG::info("'$subject' sent to {$email_parameters['email']}");
            }

        }
        catch(Exception $ex)
        {
            $data = json_encode($email_parameters);
            Log::error("Email error! '$subject': {$ex->getMessage()}");
            Log::error("Email error data: $data");
        }
    }
}
