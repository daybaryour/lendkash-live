<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// use App\Http\Requests\Api\ApiRequest;

class ForgotPasswordValidation extends FormRequest
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
               'email' => 'required|string|email|max:50',
        ];

    }
    public function messages()
    {
        return [
            'email.required'=>'The email field is required.',
            'email.email'=>'The email must be a valid email address.',
            'email.max'=>'The email may not be greater than 50 characters.'
        ];
    }
}
