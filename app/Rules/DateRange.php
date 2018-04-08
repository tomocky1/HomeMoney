<?php

namespace HomeMoney\Rules;

use Illuminate\Contracts\Validation\Rule;

class DateRange implements Rule
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
    	if(!isset($value)) {
    		return true;
    	}
    	$e = '/\d\d\d\d年\d\d月\d\d日\s-\s\d\d\d\d年\d\d月\d\d日/u';
        return preg_match($e, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attributeには日付の範囲を入力してください';
    }
}
