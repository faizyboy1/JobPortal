<?php

namespace App\Http\Requests\SuperAdmin\SmsSetting;

use App\Package;
use Illuminate\Foundation\Http\FormRequest;

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
        if (!$this->has('nexmo_status')) {
            $this->request->add(['nexmo_status' => 'deactive']);
        }

        return [
            'nexmo_key' => 'required_if:nexmo_status,active',
            'nexmo_secret' => 'required_if:nexmo_status,active',
            'nexmo_from' => 'required_if:nexmo_status,active|between:3,18',
        ];
    }
}
