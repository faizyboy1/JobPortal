<?php

namespace App\Http\Requests\SuperAdmin\PaymentSetting;

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
        $rules = [];

        // Validation request for stripe keys for stripe if stripe status in active
        if ($this->has('stripe_status')) {
            $rules["api_key"] = "required";
            $rules["api_secret"] = "required";
            $rules["webhook_key"] = "required";
        }

        if ($this->has('razorpay_status')) {
            $rules["razorpay_key"] = "required";
            $rules["razorpay_secret"] = "required";
            $rules["razorpay_webhook_secret"] = "required";
        }

        // Validation request for paypal keys for paypal if paypal status in active
        if ($this->has('paypal_status')) {
            $rules["paypal_client_id"] = "required";
            $rules["paypal_secret"] = "required";
            $rules["paypal_mode"] = "required_if:paypal_status,on|in:sandbox,live";
        }


        return $rules;
    }
}
