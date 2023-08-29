<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommissionValidation extends FormRequest
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
        'one_month_admin_loan_commission'=> 'required|min:1',
        'three_month_admin_loan_commission'=> 'required|min:1',
        'six_month_admin_loan_commission'=> 'required|min:1',
        'twelve_month_admin_loan_commission'=> 'required|min:1',

        ];
    }
    public function messages()
    {
        return [
            'one_month_admin_loan_commission.required' => 'This field is required.',
            'three_month_admin_loan_commission.required' => 'This field is required.',
            'six_month_admin_loan_commission.required' => 'This field is required.',
            'twelve_month_admin_loan_commission.required' => 'This field is required.',
            'one_month_admin_loan_commission.min' => 'This field must be at least 1.',
            'three_month_admin_loan_commission.min' => 'This field must be at least 1.',
            'six_month_admin_loan_commission.min' => 'This field must be at least 1.',
            'twelve_month_admin_loan_commission.min' => 'This field must be at least 1.',
        ];
    }

}
