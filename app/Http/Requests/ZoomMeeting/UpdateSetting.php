<?php

namespace App\Http\Requests\ZoomMeeting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSetting extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->has('enable_zoom')){ 
            return [
                "api_key" => "required",
                "secret_key" => "required",
            ];
        }
        return [];
        // $rules = [
           
        //     "api_key" => "required",
        //     "secret_key" => "required",
        // ];
        // return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
