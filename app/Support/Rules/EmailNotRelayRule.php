<?php

namespace App\Support\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class EmailNotRelayRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) : bool
    {
        return Str::after($value, '@') !== 'relaymail.email';
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message() : string
    {
        return 'Email address must be from a different provider!';
    }
}
