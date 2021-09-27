<?php

namespace App\Http\Requests\Admin\ApplicationStatus;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'status' => [
                'required',
                Rule::unique('application_status')->where(function ($query) {
                    return $query->where(['company_id' => auth()->user()->company_id, 'status' => $this->status])->where('id', '<>', $this->route('application_status'));
                }),
            ],
            'status_color' => 'required',
            'status_position' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'status' => 'name',
            'status_color' => 'color',
            'status_position' => 'position',
        ];
    }
}
