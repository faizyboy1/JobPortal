<?php

namespace App\Http\Requests\SuperAdmin\FooterSetting;

use App\PaymentSetting;
use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
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
            'title' => 'required|unique:footer_menu,name',
            'description' => 'required',
        ];
    }
}
