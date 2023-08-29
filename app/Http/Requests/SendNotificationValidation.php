<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationValidation extends FormRequest
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
            'message_en' => 'required|string|max:500',
            'message_ar' => 'required|string|max:500',
        ];
    }

    public function messages() {
        return [
            'message_en.required' => 'The message in english field is required.',
            'message_ar.required' => 'The message in arabic field is required.'
        ];
    }


}
