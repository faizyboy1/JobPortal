<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helper\Reply;
use App\Http\Requests\SuperAdmin\PaymentSetting\UpdateRequest;
use App\Package;
use App\PaymentSetting;
use App\Traits\PaymentSettings;


class SuperAdminPaymentSettingsController extends SuperAdminBaseController
{
    use PaymentSettings;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.paymentGatewayCredential';
        $this->pageIcon = 'icon-settings';
    }

    public function index()
    {
        $this->credentials = PaymentSetting::first();
        return view('super-admin.payment-setting.index', $this->data);
    }

    public function update(UpdateRequest $request)
    {
        $stripe = PaymentSetting::first();

        // Save Stripe Credentials
        $stripe->api_key = $request->api_key;
        $stripe->api_secret = $request->api_secret;
        $stripe->webhook_key = $request->webhook_key;

        // Save Paypal Credentials
        $stripe->paypal_client_id = $request->paypal_client_id;
        $stripe->paypal_secret    = $request->paypal_secret;
        $stripe->paypal_mode = $request->paypal_mode;

        // Save Active Status
        if ($request->has('paypal_status') && $request->paypal_status == 'on') {
            $stripe->paypal_status = 'active';
        } else {
            $stripe->paypal_status = 'inactive';
        }

        if ($request->has('stripe_status') && $request->stripe_status == 'on') {

            $stripe->stripe_status = 'active';
        } else {
            $stripe->stripe_status = 'inactive';
        }

        $stripe->razorpay_key = $request->razorpay_key;
        $stripe->razorpay_secret = $request->razorpay_secret;
        $stripe->razorpay_webhook_secret = $request->razorpay_webhook_secret;
        ($request->razorpay_status) ? $stripe->razorpay_status = 'active' : $stripe->razorpay_status = 'inactive';

        $stripe->save();

        $packageDataes = Package::where(function ($query) {
            $query->where('monthly_price', '!=', 0);
            $query->orWhere('annual_price', '!=', 0);
        })
            ->where(function ($query) {
                $query->whereNull('stripe_annual_plan_id');
                $query->orWhereNull('stripe_monthly_plan_id');
            })
            ->first();

        if ($packageDataes && $stripe->stripe_status == 'active') {
            return Reply::success(__('messages.updatedSuccessfully') . ' ' . __('messages.stripePlanIdRequired') . ' <a class="btn btn-warning btn-sm" href="' . route('superadmin.packages.index') . '"> ' . __('menu.packages') . ' </a>');
        }

        return Reply::success(__('messages.updatedSuccessfully'));
    }
}
