<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    private $file;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->file = "/app/app_logs/" . $date = date('Y-m-d') . "-logs.txt";
    }

    public function info($message)
    {
        $time = date('h:i:s A');
        $contents = file_get_contents($this->file);
        $contents .= "$time - $message";
        file_put_contents($this->file, $contents);
    }

    public function error($message)
    {
        $time = date('h:i:s A');
    }
}
