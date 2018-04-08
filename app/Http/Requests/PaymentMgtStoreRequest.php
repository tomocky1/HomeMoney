<?php

namespace HomeMoney\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMgtStoreRequest extends FormRequest
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
            'name' => 'required',
        	'walletId' => 'required|numeric',
        ];
    }
    
    public function attributes()
    {
    	return [
    		'name' => '支払方法名称',
    		'walletId' => '関連する財布',
    		'dorder' => '表示順',
    	];
    }
}
