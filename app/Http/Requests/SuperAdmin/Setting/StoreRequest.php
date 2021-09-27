<?php

namespace App\Http\Requests\SuperAdmin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        $data =[
            'company_name' => 'required',
            'company_email' => 'required',
            'company_phone' => 'required',
            'currency_id' => 'required',
            ];
            if ($this->has('google_recaptcha_status')) {
                    $data['version'] = 'required_if:google_recaptcha_status,active';
                    $data['google_recaptcha_key'] = 'required';
                    $data['google_recaptcha_secret'] = 'required';
                    
            }
            return $data;
        
    }
}
