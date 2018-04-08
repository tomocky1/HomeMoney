<?php

namespace HomeMoney\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranStoreRequest extends FormRequest
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
            'summery'   => 'required',
        	'paymentId' => 'exists:payments,id',
        	'exeDate'   => 'required|date',
        	'inCome'    => 'digits:8',
        	'outGoings' => 'digits:8',
        ];
    }
}
