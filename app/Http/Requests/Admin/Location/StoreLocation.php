<?php

namespace App\Http\Requests\Admin\Location;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocation extends FormRequest
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
            'locations' => 'required|array|min:1',
            'locations.0' => 'required',
            'country_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'locations.*' => __('errors.addLocations')
        ];
    }
}
