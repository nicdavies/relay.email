<?php

namespace App\Support\Rules;

use Illuminate\Contracts\Validation\Rule;

class DomainRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) : bool
    {
        return preg_match(
            "/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i",
            $value
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() : string
    {
        return 'The :attribute must be a valid domain without http(s)';
    }
}
