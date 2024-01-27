<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidEmail implements Rule
{
   
    public function passes($attribute, $value)
    {
        // Check if the email has a valid domain
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function message()
    {
        return 'The :attribute must be a valid email address.';
    }
}
