<?php

namespace App\Helpers;

class CustomHelpers
{
    public function format_money($input)
    {
        return number_format((float)$input / 100, 2, '.', '');
    }
}