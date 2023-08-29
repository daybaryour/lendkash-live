<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBankValidation extends FormRequest
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
            'bank_name'=> 'required',
            // 'bvn'=> 'required|integer|min:1|digits:11',
            'account_number'=> 'required|integer|min:1|digits:10',
            'account_holder_name'=> 'required|string'
        ];
    }
}
