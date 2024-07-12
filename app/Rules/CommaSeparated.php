<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CommaSeparated implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        // Validate that the string matches the required format
        return preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $value);
    }

    public function message()
    {
        return 'The :attribute must be in the format: item, item2, item3';
    }
}
