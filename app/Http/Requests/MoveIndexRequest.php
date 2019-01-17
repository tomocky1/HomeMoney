<?php

namespace HomeMoney\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use HomeMoney\Rules\DateRange;

class MoveIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tradeDateRange' => [ new DateRange() ],
        ];
    }
    
    public function attributes()
    {
    	return [
    		'tradeDateRange' => '日付'
    	];
    }
}
