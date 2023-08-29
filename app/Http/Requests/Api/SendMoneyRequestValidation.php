<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SendMoneyRequestValidation extends ApiRequest
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
            //'mobile_number'=>'required|numeric|digits_between:10,11',
            'user_id'=>'required|numeric',
            'amount'=> 'required|numeric|min:1|max:1000000'


        ];
    }



}
