<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletCommissionValidation extends FormRequest
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
            'wallet_commission_to_bank_account'=> 'required|min:1',
            'commission_for_loan_request'=> 'required|min:1',

        ];
    }
    public function messages()
    {
        return [
            'wallet_commission_to_bank_account.required' => 'This field is required.',
            'wallet_commission_to_bank_account.min' => 'This field must be at least 1.',
            'commission_for_loan_request.required' => 'This field is required.',
            'commission_for_loan_request.min' => 'This field must be at least 1.',
        ];
    }

}
