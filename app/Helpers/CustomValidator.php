<?php

namespace App\Helpers;

class CustomValidator
{
    public function validate_pressence($array_to_validate, $required_properties_array)
    {
        foreach ($required_properties_array as $required_property)
        {
            if (!array_key_exists($required_property, $array_to_validate))
                abort(400, 'Input data invalid');
        }
    }
}