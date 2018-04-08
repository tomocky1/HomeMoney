<?php

namespace HomeMoney\Rules;

use Illuminate\Contracts\Validation\Rule;

class Yen implements Rule
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

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!isset($value)) {
        	return true;
        }
        $e = '/\d{1,3}(,\d{3})*\s円/';
        return preg_match($e, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute の円形式が不正です。';
    }
}
