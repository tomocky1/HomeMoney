<?php

namespace HomeMoney\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use HomeMoney\Rules\Yen;

class MoveStoreRequest extends FormRequest
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
    			'srcWalletId' => 'required',
    			'distWalletId' => 'required',
    			'summery'    => 'required',
    			'amount'     => ['required', new Yen() ],
    			'settleDate' => 'required|date_format:Y年m月d日',
    	];
    	
    }
}
