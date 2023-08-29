<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CompleteKycValidation extends ApiRequest
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
            'dob'=> 'required',
            'address'=> 'required',
            'employer_detail'=> 'required',
            'country_id'=> 'required|numeric',
            'state_id'=> 'required|numeric',
            'city_id'=> 'required|numeric',
            'bank_name'=> 'required',
            'bvn'=> 'required',
            'account_holder_name'=> 'required',
            'account_number'=> 'required',
            'id_proof_document'=> 'mimes:jpeg,png,jpg,pdf|max:15360',
            'employment_document'=> 'mimes:jpeg,png,jpg,pdf|max:15360',


        ];
    }
    public function messages()
    {
        return [
            'id_proof_document.max'=>'The id proof document should not greater than 15 MB.',
            'employment_document.max'=>'The employment document should not greater than 15 MB.'
        ];
    }


}
