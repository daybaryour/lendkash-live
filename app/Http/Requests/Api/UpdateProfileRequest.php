<?php

namespace App\Http\Requests\Api;

class UpdateProfileRequest extends ApiRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required|string',
            'address' => 'required|string',
            'image' => 'mimes:jpeg,jpg,png',
        ];
    }
}

?>
