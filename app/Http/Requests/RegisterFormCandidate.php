<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class RegisterFormCandidate extends FormRequest
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

        $rules = [
            'full_name' => 'required',
            'email' => 'email|required',
            'phone' => 'required',
            'photo' => 'mimes:jpeg,jpg,png',
            'resume' => 'mimes:jpeg,jpg,png,doc,docx,rtf,xls,xlsx,pdf',
            'password' => 'required|string|min:6',
            'country' => 'required|string',
            'education' => 'required|string',
            'experience' => 'required|string|min:1',
            'citizenship' => 'required|string',
            'relocatable' => 'required|integer',
            'transferable' => 'required|integer'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
        ];
    }
}
