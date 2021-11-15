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
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required',
            // 'photo' => 'mimes:jpeg,jpg,png',
            // 'resume' => 'mimes:jpeg,jpg,png,doc,docx,rtf,xls,xlsx,pdf',
            'password' => 'required|string|min:6',
            'ctg_id' => 'required'
            // 'country' => 'required|string',
            // 'education' => 'required|string',
            // 'experience' => 'required|string|min:1',
            // 'citizenship' => 'required|string',
            // 'relocatable' => 'required|integer',
            // 'transferable' => 'required|integer'
        ];
        if(!is_null('first_name') || !is_null('_name')){
            // $rules.
        }

        return $rules;
    }

    public function messages()
    {
        return [
        ];
    }
}
