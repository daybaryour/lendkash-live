<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestCommissionValidation extends FormRequest
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
            'six_month_interest'=> 'required|numeric|gt:0',
            'twelve_month_interest'=> 'required|numeric|gt:0',

        ];
    }
    public function messages()
    {
        return [
            'six_month_interest.required' => 'This field is required.',
            'twelve_month_interest.required' => 'This field is required.',
            'six_month_interest.min' => 'This field must be at least 1.',
            'twelve_month_interest.min' => 'This field must be at least 1.',
        ];
    }

}
