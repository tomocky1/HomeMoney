<?php

namespace HomeMoney\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use HomeMoney\Rules\Yen;

class OutgoingStoreRequest extends FormRequest
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
        'accountId' => 'required',
        'paymentId' => 'required',
        'summery'    => 'required',
        'amount'     => ['required', new Yen() ],
        'tradeDate' => 'required|date_format:Y年m月d日',
        'settleDate' => 'required|date_format:Y年m月d日',
        ];
    }
}
