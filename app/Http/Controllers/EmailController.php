<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    private $headers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->headers = 'MIME-Version: 1.0'
        . "\n" . 'Content-type: text/html; charset=iso-8859-1'
        . "\n" . 'From: Sean\'s Test<noreply@test.com>'
        . "\n";
    }

    public function send(Request $request) 
    {
        $view = view('email/send', ['title' => $request->title, 'content' => $request->content]);
        mail('sumler.sean@gmail.com', 'A new test!!!', $view, $this->headers);

        return response(json_encode(true), 200)
            ->header('Content-Type', 'json');
    }
}
