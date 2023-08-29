<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OtpVerifyValidation extends ApiRequest
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
            //digits_between:9,10
//            'phone_number'=>'required',
            'otp'  =>'required',
//            'device_type'  =>'required',
        ];
    }
    public function messages()
    {
        return [
            'mobile_number.digits_between'=>'The phone number must be 9 to 10 digits.'
        ];
    }
}
