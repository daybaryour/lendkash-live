<?php

namespace App\Http\Requests\Api;

class RegistrationValidation extends ApiRequest
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
            'name' => 'required|string|max:50',
            'password'=> 'required|min:6|max:20',
            'email'=>'required|email|string|unique:users',
            'mobile_number'=>'required|unique:users|numeric|digits_between:10,11',
            'user_image' => 'image|mimes:jpeg,png,jpg|max:2048',

        ];
    }


}
