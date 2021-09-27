<?php

namespace App\Http\Requests\Admin\Document;

use App\Package;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{

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
            'name' => [
                'required',
                Rule::unique('documents')->where(function ($query)
                {
                    return $query->whereDocumentableType(substr($this->documentable_type, 1))->whereDocumentableId($this->documentable_id)->whereName($this->name);
                })
            ],
            'file' => 'required|mimes:jpeg,jpg,png,gif,txt,doc,docx,rtf,xls,xlsx,pdf'
        ];
    }
}
