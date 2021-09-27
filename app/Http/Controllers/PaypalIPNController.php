<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyPackage;
use App\Notifications\CompanyPurchasedPlan;
use App\Notifications\CompanyUpdatedPlan;
use App\PaypalInvoice;
use App\StripeInvoice;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PaypalIPNController extends Controller
{
    public function verifyBillingIPN(Request $request)
    {
        $txnType = $request->get('txn_type');
        if ($txnType == 'recurring_payment') {

            $recurringPaymentId = $request->get('recurring_payment_id');
            $eventId = $request->get('ipn_track_id');

            $event = PaypalInvoice::where('event_id', $eventId)->count();

            if($event == 0)
            {
                $payment =  PaypalInvoice::where('transaction_id', $recurringPaymentId)->first();

                $today = Carbon::now();

                $nextPaymentDate = null;

                $company = Company::where('id', $payment->company_id)->first();

                if($company->package_type == 'annual') {
                    $nextPaymentDate = $today->addYear();
                } else if($company->package_type == 'monthly') {
                    $nextPaymentDate = $today->addMonth();
                }

                $paypalInvoice = new PaypalInvoice();
                $paypalInvoice->transaction_id = $recurringPaymentId;
                $paypalInvoice->company_id = $payment->company_id;
                $paypalInvoice->currency_id = $payment->currency_id;
                $paypalInvoice->total = $payment->total;
                $paypalInvoice->status = 'paid';
                $paypalInvoice->plan_id = $payment->plan_id;
                $paypalInvoice->billing_frequency = $payment->billing_frequency;
                $paypalInvoice->event_id = $eventId;
                $paypalInvoice->billing_interval = 1;
                $paypalInvoice->paid_on = $today;
                $paypalInvoice->next_pay_date = $nextPaymentDate;
                $paypalInvoice->save();

                // Change company status active after payment
                $company->status = 'active';
                $company->save();

                $companyPackage = CompanyPackage::where('company_id', $company->id)->orderBy('created_at', 'Desc')->first();

                if($companyPackage){
                    $companyPackage->paypal_id = $paypalInvoice->id;
                    $companyPackage->save();
                }

                // Notification to superadmin
                $superAdmin = User::whereNull('company_id')->get();
                $lastInvoice = StripeInvoice::where('company_id')->first();


                if($lastInvoice){
                    Notification::send($superAdmin, new CompanyUpdatedPlan($company, $payment->plan_id));
                }else{
                    Notification::send($superAdmin, new CompanyPurchasedPlan($company, $payment->plan_id));
                }

                return response('IPN Handled', 200);
            }

        }
    }
}
