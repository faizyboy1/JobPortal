<?php

namespace App\Http\Requests\Language;

use App\Http\Requests\CoreRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLanguage extends CoreRequest
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
            'language_name' => 'required|unique:language_settings,language_name,'.request('id'),
            'language_code' => 'required|unique:language_settings,language_code,'.request('id'),
            'status' => [
                'required',
                Rule::in(['enabled', 'disabled'])
            ]
        ];
    }

    public function messages()
    {
        return [
            'language_name.required' => __('app.name').' '.__('errors.fieldRequired'),
            'language_code.required' => __('app.code').' '.__('errors.fieldRequired'),
            'language_name.unique' => __('app.name').' '.__('errors.alreadyTaken'),
            'language_code.unique' => __('app.code').' '.__('errors.alreadyTaken')
        ];
    }
}
