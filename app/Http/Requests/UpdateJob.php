<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class UpdateJob extends CoreRequest
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
            
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => __('menu.jobCategories').' '.__('errors.fieldRequired'),
            'location_id.required' => __('menu.locations').' '.__('errors.fieldRequired')
        ];
    }
}
