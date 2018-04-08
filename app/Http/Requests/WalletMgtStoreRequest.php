<?php

namespace HomeMoney\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletMgtStoreRequest extends FormRequest
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
            'dorder' => 'required|numeric'
        ];
    }
    
    public function attributes()
    {
    	return [
    		'name' => '財布名称',
    		'dorder' => '表示順'
    	];
    }
}
