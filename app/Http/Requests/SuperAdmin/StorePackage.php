<?php

namespace App\Http\Requests\SuperAdmin;

use App\PaymentSetting;
use Illuminate\Foundation\Http\FormRequest;

class StorePackage extends FormRequest
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

        $data = [
            'name' => 'required',
            'monthly_price' => 'required|numeric',
            'annual_price' => 'required|numeric',
            'no_of_job_openings' => 'nullable|numeric',
            'no_of_candidate_access' => 'nullable|numeric',
            'trial_duration' => 'nullable|numeric',
        ];

        $paymentSetting = PaymentSetting::first();

        if($this->get('annual_price') > 0 && $this->get('monthly_price') > 0  && $paymentSetting->stripe_status == 'active'){
            $data['stripe_annual_plan_id'] = 'required';
            $data['stripe_monthly_plan_id'] = 'required';
        }

        if(($this->get('annual_price') > 0 && $this->get('monthly_price') > 0 ) &&  $paymentSetting->razorpay_status == 'active'){
            $data['razorpay_annual_plan_id'] = 'required';
            $data['razorpay_monthly_plan_id'] = 'required';
        }

        return $data;
    }
}
