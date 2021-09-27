<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyPackage;
use App\Notifications\CompanyPurchasedPlan;
use App\Notifications\CompanyUpdatedPlan;
use App\PaymentSetting;
use App\StripeInvoice;
use App\Subscription;
use App\Traits\StripeSettings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Stripe\Stripe;
use Stripe\Webhook;
use Illuminate\Support\Facades\Notification;

class StripeWebhookController extends Controller
{
    use StripeSettings;

    public function saveInvoices(Request $request) {
        $this->setStripConfigs();
        $settings = PaymentSetting::first();

        Stripe::setApiKey(config('cashier.secret'));

        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = $settings->webhook_key;

        $payload = @file_get_contents("php://input");
        $sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            return response('Invalid Payload', 400);
        }catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('Invalid signature', 400);
        }

        $payload = json_decode($request->getContent(), true);
//        \Log::debug($payload);
        // Do something with $event
        if ($payload['type'] == 'invoice.payment_succeeded')
        {
            \Log::debug($payload);
//            return response('Webhook Handled', 200);
            $planId = $payload['data']['object']['lines']['data'][0]['plan']['id'];
            $customerId = $payload['data']['object']['customer'];
            $amount = $payload['data']['object']['amount_paid'];
            $transactionId = $payload['data']['object']['lines']['data'][0]['id'];
//            $invoiceId = $payload['data']['object']['number'];
            $invoiceRealId = $payload['data']['object']['id'];

            $company = Company::where('stripe_id', $customerId)->first();

            $package = \App\Package::where(function ($query) use($planId) {
                $query->where('stripe_annual_plan_id', '=', $planId)
                    ->orWhere('stripe_monthly_plan_id', '=', $planId);
            })->first();

            if($company) {
                // Store invoice details
                $stripeInvoice = new StripeInvoice();
                $stripeInvoice->company_id = $company->id;
                $stripeInvoice->invoice_id = $invoiceRealId;
                $stripeInvoice->transaction_id = $transactionId;
                $stripeInvoice->amount = $amount/100;
                $stripeInvoice->package_id = $package->id;
                $stripeInvoice->pay_date = \Carbon\Carbon::now()->format('Y-m-d');
                $stripeInvoice->next_pay_date = \Carbon\Carbon::createFromTimeStamp($company->upcomingInvoice()->next_payment_attempt)->format('Y-m-d');

                $stripeInvoice->save();

                $companyPackage = CompanyPackage::where('company_id', $company->id)->orderBy('created_at', 'Desc')->first();

                if($companyPackage){
                    $companyPackage->stripe_id = $stripeInvoice->id;
                    $companyPackage->save();
                }

                // Change company status active after payment
                $company->status = 'active';
                $company->save();

                // Notification to superadmin
                $superAdmin = User::whereNull('company_id')->get();
                $lastInvoice = StripeInvoice::where('company_id')->first();

                if($lastInvoice){
                    Notification::send($superAdmin, new CompanyUpdatedPlan($company, $package->id));
                }else{
                    Notification::send($superAdmin, new CompanyPurchasedPlan($company, $package->id));
                }

                return response('Webhook Handled', 200);
            }

            return response('Customer not found', 200);
        }

        elseif ($payload['type'] == 'invoice.payment_failed') {
            $customerId = $payload['data']['object']['customer'];

            $company = Company::where('stripe_id', $customerId)->first();
            $subscription = Subscription::where('comapny_id', $company->id)->first();

            if($subscription){
                $subscription->ends_at = \Carbon\Carbon::createFromTimeStamp($payload['data']['object']['current_period_end'])->format('Y-m-d');
                $subscription->save();
            }

            if($company) {

                $company->licence_expire_on = \Carbon\Carbon::createFromTimeStamp($payload['data']['object']['current_period_end'])->format('Y-m-d');
                $company->save();

                return response('Company subscription canceled', 200);
            }

            return response('Customer not found', 200);
        }
    }
}
