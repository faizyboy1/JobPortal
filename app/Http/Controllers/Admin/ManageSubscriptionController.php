<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\CompanyPackage;
use App\GlobalSetting;
use App\Helper\Reply;
use App\Http\Requests\Payment\PaymentRequest;
use App\PaymentSetting;
use App\PaypalInvoice;
use App\RazorpayInvoice;
use App\RazorpaySubscription;
use App\Traits\StripeSettings;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Package;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Razorpay\Api\Api;
use Stripe\Subscription;
use Yajra\DataTables\DataTables;

class ManageSubscriptionController extends AdminBaseController
{
    use StripeSettings;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.subscription';
        $this->pageIcon = 'ti-settings';
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->packages = Package::where('is_trial', 0)->where('status', 1)->where('is_private',0)->get();
        $this->subscription = \App\Subscription::where('company_id', company()->id)->orderBy('created_at', 'desc')->first();
        $this->razorPaySubscription = RazorpaySubscription::where('company_id', company()->id)->orderBy('created_at', 'Desc')->first();

        $stripe = DB::table("stripe_invoices")
            ->join('packages', 'packages.id', 'stripe_invoices.package_id')
            ->selectRaw('stripe_invoices.id , "Stripe" as method, stripe_invoices.pay_date as paid_on ,stripe_invoices.next_pay_date, stripe_invoices.created_at')
            ->whereNotNull('stripe_invoices.pay_date')
            ->where('stripe_invoices.company_id', company()->id);
        $razorpay = DB::table("razorpay_invoices")
            ->join('packages', 'packages.id', 'razorpay_invoices.package_id')
            ->selectRaw('razorpay_invoices.id , "Razorpay" as method, razorpay_invoices.pay_date as paid_on,razorpay_invoices.next_pay_date, razorpay_invoices.created_at')
            ->whereNotNull('razorpay_invoices.pay_date')
            ->where('razorpay_invoices.company_id', company()->id);

        $allInvoices = DB::table("paypal_invoices")
            ->join('packages', 'packages.id', 'paypal_invoices.package_id')
            ->selectRaw('paypal_invoices.id, "Paypal" as method, paypal_invoices.paid_on,paypal_invoices.next_pay_date,paypal_invoices.created_at')
            ->where('paypal_invoices.status', 'paid')
            ->whereNull('paypal_invoices.end_on')
            ->where('paypal_invoices.company_id', company()->id)
            ->union($stripe)
            ->union($razorpay)
            ->get();

        $this->firstInvoice = $allInvoices->sortByDesc(function ($temp, $key) {
            return Carbon::parse($temp->created_at)->getTimestamp();
        })->first();

        $this->paypalInvoice = PaypalInvoice::where('company_id', company()->id)->orderBy('created_at', 'desc')->first();

        $this->paymentSetting = PaymentSetting::first();

        return view('admin.subscription.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function invoice()
    {
        $this->pageTitle ='menu.subscriptionInvoice';
        return view('admin.subscription.paypal-invoice', $this->data);
    }

    public function data()
    {
        $stripe = DB::table("stripe_invoices")
            ->join('packages', 'packages.id', 'stripe_invoices.package_id')
            ->selectRaw('stripe_invoices.id ,stripe_invoices.invoice_id , packages.name as name, "Stripe" as method,stripe_invoices.amount, stripe_invoices.pay_date as paid_on ,stripe_invoices.next_pay_date,stripe_invoices.created_at')
            ->whereNotNull('stripe_invoices.pay_date')
            ->where('stripe_invoices.company_id', company()->id);

        $razorpay = DB::table("razorpay_invoices")
            ->join('packages', 'packages.id', 'razorpay_invoices.package_id')
            ->selectRaw('razorpay_invoices.id ,razorpay_invoices.invoice_id , packages.name as name, "Razorpay" as method,razorpay_invoices.amount, razorpay_invoices.pay_date as paid_on ,razorpay_invoices.next_pay_date,razorpay_invoices.created_at')
            ->whereNotNull('razorpay_invoices.pay_date')
            ->where('razorpay_invoices.company_id', company()->id);

        $paypal = DB::table("paypal_invoices")
            ->join('packages', 'packages.id', 'paypal_invoices.package_id')
            ->selectRaw('paypal_invoices.id,"" as invoice_id, packages.name as name, "Paypal" as method ,paypal_invoices.total as amount, paypal_invoices.paid_on,paypal_invoices.next_pay_date, paypal_invoices.created_at')
            ->where('paypal_invoices.status', 'paid')
            ->where('paypal_invoices.company_id', user()->company_id)
            ->orderBy('paypal_invoices.created_at', 'desc')
            ->union($stripe)
            ->union($razorpay)
            ->get();

        $paypalData = $paypal->sortByDesc(function ($temp, $key) {
            return Carbon::parse($temp->created_at)->getTimestamp();
        })->all();

        return DataTables::of($paypalData)
            ->editColumn('name', function ($row) {
                return ucfirst($row->name);
            })
            ->editColumn('paid_on', function ($row) {
                if(!is_null($row->paid_on)) {
                    return Carbon::parse($row->paid_on)->format('d-m-Y');
                }
                return '-';
            })
            ->editColumn('next_pay_date', function ($row) {
                if(!is_null($row->next_pay_date)) {
                    return Carbon::parse($row->next_pay_date)->format('d-m-Y');
                }
                return '-';
            })
            ->addColumn('action', function ($row) {
                if($row->method == 'Stripe'){
                    return '<a href="'.route('admin.subscribe.invoice-download', $row->invoice_id).'" class="btn btn-primary btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>';
                }
                if($row->method == 'Paypal'){
                    return '<a href="'.route('admin.subscribe.paypal-invoice-download', $row->id).'" class="btn btn-primary btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>';
                }
                if($row->method == 'Razorpay'){
                    return '<a href="'.route('admin.subscribe.razorpay-invoice-download', $row->id).'" class="btn btn-primary btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>';
                }
                return '';
            })

            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function payment(PaymentRequest $request) {

        $this->setStripConfigs();
        $token = $request->payment_method;
        $email = $request->stripeEmail;

        $plan = Package::find($request->plan_id);

        $stripe = DB::table("stripe_invoices")
            ->join('packages', 'packages.id', 'stripe_invoices.package_id')
            ->selectRaw('stripe_invoices.id , "Stripe" as method, stripe_invoices.pay_date as paid_on ,stripe_invoices.next_pay_date')
            ->whereNotNull('stripe_invoices.pay_date')
            ->where('stripe_invoices.company_id', company()->id);

        $razorpay = DB::table("razorpay_invoices")
            ->join('packages', 'packages.id', 'razorpay_invoices.package_id')
            ->selectRaw('razorpay_invoices.id ,"Razorpay" as method, razorpay_invoices.pay_date as paid_on ,razorpay_invoices.next_pay_date')
            ->whereNotNull('razorpay_invoices.pay_date')
            ->where('razorpay_invoices.company_id', company()->id);

        $allInvoices = DB::table("paypal_invoices")
            ->join('packages', 'packages.id', 'paypal_invoices.package_id')
            ->selectRaw('paypal_invoices.id, "Paypal" as method, paypal_invoices.paid_on,paypal_invoices.next_pay_date')
            ->where('paypal_invoices.status', 'paid')
            ->whereNull('paypal_invoices.end_on')
            ->where('paypal_invoices.company_id', company()->id)
            ->union($stripe)
            ->union($razorpay)
            ->get();

        $firstInvoice = $allInvoices->sortByDesc(function ($temp, $key) {
            return Carbon::parse($temp->paid_on)->getTimestamp();
        })->first();

        $subcriptionCancel = true;

        if(!is_null($firstInvoice) && $firstInvoice->method == 'Paypal'){
            $subcriptionCancel = $this->cancelSubscriptionPaypal();
        }
        if(!is_null($firstInvoice) && $firstInvoice->method == 'Razorpay'){
            $subcriptionCancel = $this->cancelSubscriptionPaypal();
        }

        if($subcriptionCancel){

            $company = Company::where('id', company()->id)->first();
            $subscription = $company->subscriptions;

            try {
                if ($subscription->count() > 0) {
                    $company->subscription('main')->swap($plan->{'stripe_'. $request->type .'_plan_id'});
                }
                else {
                    $company->newSubscription('main', $plan->{'stripe_'.$request->type.'_plan_id'})->create($token, [
                        'email' => $email,
                    ]);
                }

                $company->package_id = $plan->id;
                $company->package_type = $request->type;
                $company->status = 'active'; // Set company status active
                $company->licence_expire_on = null;
                $company->save();

                CompanyPackage::where('company_id', $company->id)
                    ->update(['status' => 'inactive', 'end_date' => Carbon::now(company()->timezone)->format('Y-m-d')]);

                $companyPackages = new CompanyPackage();
                $companyPackages->package_id = $plan->id;
                $companyPackages->package_id = $plan->id;
                $companyPackages->company_id = $company->id;
                $companyPackages->start_date = Carbon::now(company()->timezone)->format('Y-m-d');
                if ($company->package_type == 'monthly') {
                    $companyPackages->end_date = Carbon::now(company()->timezone)->addMonth()->format('Y-m-d');
                } else {
                    $companyPackages->end_date = Carbon::now(company()->timezone)->addYear()->format('Y-m-d');
                }
                $companyPackages->status = 'active';
                $companyPackages->save();

                $company->package_id = $plan->id;
                $company->package_type = $request->type;

                // Set company status active
                $company->status = 'active';
                $company->licence_expire_on = null;

                $company->save();
                \Session::flash('success', 'Payment successfully done.');
                return redirect(route('admin.subscribe.index'));

            } catch (\Exception $e) {
                return back()->withError($e->getMessage())->withInput();
            }
        }
        return back()->withError('User not found by ID ' . $request->input('user_id'))->withInput();
    }

    // Stripe invoice Download
    /**
     * @param Request $request
     * @param $invoiceId
     * @return mixed
     */
    public function download(Request $request, $invoiceId) {
        $this->setStripConfigs();
        $this->company = company();
        return $this->company->downloadInvoice($invoiceId, [
            'vendor'  => $this->company->company_name,
            'product' => $this->company->package->name,
            'global' => GlobalSetting::first(),
            'logo' => $this->company->logo,
        ]);
    }

    // Paypal invoice download
    public function paypalInvoiceDownload($id)
    {
        $this->invoice = PaypalInvoice::with(['company','currency','package'])->findOrFail($id);

        $this->company = company();
        $this->superSettings =  GlobalSetting::first();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('paypal-invoice.invoice-1', $this->data);
        $filename = $this->invoice->paid_on->format("dS M Y").'-'.$this->invoice->next_pay_date->format("dS M Y");
        return $pdf->download($filename . '.pdf');
    }

    // Default Super-admin invoice download
    public function invoiceDownload($id)
    {
        $this->invoice = CompanyPackage::with(['company','package'])->findOrFail($id);
        $this->amount = 0;

        if($this->invoice->package_type == 'monthly'){
            $this->amount = $this->invoice->package->monthly_price;

        }elseif($this->invoice->package_type == 'annual'){
            $this->amount = $this->invoice->package->annual_price;
        }

        $this->company = company();
        $this->superSettings =  GlobalSetting::with('currency')->first();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('default-invoice.invoice-1', $this->data);
        $filename = $this->invoice->start_date->format("dS M Y").'-'.$this->invoice->end_date->format("dS M Y");
        return $pdf->download($filename . '.pdf');
    }

    // Paypal Subscription cancel
    /**
     * @return bool
     */
    public function cancelSubscriptionPaypal(){
        $credential = PaymentSetting::first();
        $paypal_conf = Config::get('paypal');
        $api_context = new ApiContext(new OAuthTokenCredential($credential->paypal_client_id, $credential->paypal_secret));
        $api_context->setConfig($paypal_conf['settings']);

        $paypalInvoice = PaypalInvoice::whereNotNull('transaction_id')->whereNull('end_on')
            ->where('company_id', company()->id)->where('status', 'paid')->first();

        if($paypalInvoice){
            $agreementId = $paypalInvoice->transaction_id;
            $agreement = new Agreement();

            $agreement->setId($agreementId);
            $agreementStateDescriptor = new AgreementStateDescriptor();
            $agreementStateDescriptor->setNote("Cancel the agreement");

            try {
                $agreement->cancel($agreementStateDescriptor, $api_context);
                $cancelAgreementDetails = Agreement::get($agreement->getId(), $api_context);

                // Set subscription end date
                $paypalInvoice->end_on = Carbon::parse($cancelAgreementDetails->agreement_details->final_payment_date)->format('Y-m-d H:i:s');
                $paypalInvoice->save();

            } catch (\Exception $ex) {
                //\Session::put('error','Some error occur, sorry for inconvenient');
                return false;
            }

            return true;
        }
    }

    // Paypal And Stripe Subscription cancel
    /**
     * @param $type
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function cancelSubscription($type) {
        $credential = PaymentSetting::first();
        if($type == 'Paypal') {
            $credential = PaymentSetting::first();
            $paypal_conf = Config::get('paypal');
            $api_context = new ApiContext(new OAuthTokenCredential($credential->paypal_client_id, $credential->paypal_secret));
            $api_context->setConfig($paypal_conf['settings']);

            $paypalInvoice = PaypalInvoice::whereNotNull('transaction_id')->whereNull('end_on')
                ->where('company_id', company()->id)->where('status', 'paid')->first();

            if ($paypalInvoice) {
                $agreementId = $paypalInvoice->transaction_id;
                $agreement = new Agreement();

                $agreement->setId($agreementId);
                $agreementStateDescriptor = new AgreementStateDescriptor();
                $agreementStateDescriptor->setNote("Cancel the agreement");

                try {
                    $agreement->cancel($agreementStateDescriptor, $api_context);
                    $cancelAgreementDetails = Agreement::get($agreement->getId(), $api_context);

                    // Set subscription end date
                    $paypalInvoice->end_on = Carbon::parse($cancelAgreementDetails->agreement_details->final_payment_date)->format('Y-m-d H:i:s');
                    $paypalInvoice->save();
                } catch (\Exception $ex) {
                    \Session::put('error', 'Some error occur, sorry for inconvenient');
                    return Reply::redirect(route('admin.subscribe.index'));
                }
            }

        }elseif($type == 'Razorpay'){

                $apiKey    = $credential->razorpay_key;
                $secretKey = $credential->razorpay_secret;
                $api       = new Api($apiKey, $secretKey);

                // Get subscription for unsubscribe
                $subscriptionData = RazorpaySubscription::where('company_id', company()->id)->whereNull('ends_at')->first();
                if($subscriptionData){
                    try {
//                  $subscriptions = $api->subscription->all();
                        $subscription  = $api->subscription->fetch($subscriptionData->subscription_id);
                        if($subscription->status == 'active'){

                            // unsubscribe plan
                            $subData = $api->subscription->fetch($subscriptionData->subscription_id)->cancel(['cancel_at_cycle_end' => 1]);

                            // plan will be end on this date
                            $subscriptionData->ends_at = \Carbon\Carbon::createFromTimestamp($subData->end_at)->format('Y-m-d');
                            $subscriptionData->save();
                        }
                        elseif ($subscription->status == 'cancelled'){
                            $subscriptionData->ends_at = \Carbon\Carbon::createFromTimestamp($subscription->end_at)->format('Y-m-d');
                            $subscriptionData->save();
                        }

                    } catch (\Exception $ex) {
                        \Session::put('error','Some error occur, sorry for inconvenient');
                        return Reply::redirect(route('admin.subscribe.index'));
                    }
                }

            } else{
            $this->setStripConfigs();
            $company = company();
            $subscription = Subscription::where('company_id', company()->id)->whereNull('ends_at')->first();
            if($subscription){
                try {
                    $company->subscription('main')->cancel();
                } catch (\Exception $ex) {
                    \Session::put('error','Some error occur, sorry for inconvenient');
                    return Reply::redirect(route('admin.subscribe.index'));
                }
            }
        }

        return Reply::redirect(route('admin.subscribe.index'), __('messages.unsubscribeSuccess'));
    }

    public function cancelSubscriptionRazorpay(){
        $credential = PaymentSetting::first();
        $apiKey    = $credential->razorpay_key;
        $secretKey = $credential->razorpay_secret;
        $api       = new Api($apiKey, $secretKey);

        // Get subscription for unsubscribe
        $subscriptionData = RazorpaySubscription::where('company_id', company()->id)->whereNull('ends_at')->first();

        if($subscriptionData){
            try {
//                  $subscriptions = $api->subscription->all();
                $subscription  = $api->subscription->fetch($subscriptionData->subscription_id);
                if($subscription->status == 'active'){

                    // unsubscribe plan
                    $subData = $api->subscription->fetch($subscriptionData->subscription_id)->cancel(['cancel_at_cycle_end' => 0]);

                    // plan will be end on this date
                    $subscriptionData->ends_at = \Carbon\Carbon::createFromTimestamp($subData->end_at)->format('Y-m-d');
                    $subscriptionData->save();
                }

            } catch (\Exception $ex) {
                return false;
            }
            return true;
        }
    }


    public function selectPackage(Request $request, $packageID) {
        $this->setStripConfigs();
        $this->package = Package::findOrFail($packageID);
        $this->company = company();
        $this->type    = $request->type;
        $this->stripeSettings = PaymentSetting::first();

        if(is_null($this->global->logo)) {
            $this->logo = asset('assets/images/logo.png');
        }
        else if(!is_null($this->superSettings->logo)){
            $this->logo = asset('user-uploads/global-logo/'.$this->superSettings->logo) ;
        }
        else {
            $this->logo = '' ;
        }
        return View::make('admin.subscription.payment-method-show', $this->data);
    }

    public function history()
    {
        $this->pageTitle = 'menu.history';
        $this->companyPackage = CompanyPackage::activePackage($this->global->id);
        $this->company = Company::with('packages')->withoutGlobalScope('company')->findOrFail($this->global->id);
        return view('admin.subscription.history', $this->data);
    }

    public function historyData()
    {
        $packages = CompanyPackage::select('company_packages.id','packages.name','company_packages.package_type',
            'company_packages.start_date','company_packages.end_date','company_packages.status',
            'company_packages.stripe_id','stripe_invoices.invoice_id', 'company_packages.paypal_id')
            ->join('packages', 'packages.id', 'company_packages.package_id')
            ->leftJoin('stripe_invoices', 'stripe_invoices.id', 'company_packages.stripe_id')
            ->leftJoin('paypal_invoices', 'paypal_invoices.id', 'company_packages.paypal_id')
        ->where('company_packages.company_id', $this->global->id)->get();


        return DataTables::of($packages)
            ->editColumn('name', function ($row) {
                return ucfirst($row->name);
            })
            ->editColumn('start_date', function ($row) {
                if(!is_null($row->start_date)) {
                    return Carbon::parse($row->start_date)->format('d M, Y');
                }
                return '-';
            })
            ->addColumn('payment_method', function ($row) {

                if($row->stripe_id != null){
                    return 'Stripe';
                }
                else if($row->paypal_id != null){
                    return 'Paypal';
                }
                else{
                    return 'Cash';
                }
            })
            ->editColumn('end_date', function ($row) {
                if(!is_null($row->end_date)) {
                    return Carbon::parse($row->end_date)->format('d M, Y');
                }
                return '-';
            })

            ->editColumn('package_type', function ($row) {
                if(!is_null($row->package_type)) {
                    return ucfirst($row->package_type);
                }
                return '-';
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'active'){
                    return '<label class="badge bg-success">'.__('app.active').'</label>';

                }
                else{
                    return '<label class="badge bg-danger">'.__('app.inactive').'</label>';
                }

            })
            ->addColumn('action', function ($row) {
                $string = '';

                if($row->stripe_id != null){
                    $string .= '<a href="'.route('admin.subscribe.invoice-download', $row->invoice_id).'" class="btn btn-primary btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>';
                }
               else if($row->paypal_id != null){
                   $string .= '<a href="'.route('admin.subscribe.paypal-invoice-download', $row->paypal_id).'" class="btn btn-primary btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>';
                }
                else{
                    $string .= '<a href="'.route('admin.subscribe.default-invoice-download', $row->id).'" class="btn btn-primary btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>';
                }
                 return   $string;

            })

            ->rawColumns(['action', 'status'])
            ->removeColumn('stripe_id')
            ->removeColumn('paypal_id')
            ->addIndexColumn()
            ->make(true);
    }

    public function razorpayPayment(Request $request){
        $credential = PaymentSetting::first();
        $this->company = company();
        $apiKey    = $credential->razorpay_key;
        $secretKey = $credential->razorpay_secret;

        $paymentId = request('paymentId');
        $razorpaySignature = $request->razorpay_signature;
        $subscriptionId = $request->subscription_id;

        $api = new Api($apiKey, $secretKey);

        $plan = Package::find($request->plan_id);
        $type = $request->type;

        $expectedSignature = hash_hmac('sha256', $paymentId . '|' . $subscriptionId, $secretKey);

        if($expectedSignature === $razorpaySignature){

            try {
                $api->payment->fetch($paymentId);

                $payment = $api->payment->fetch($paymentId); // Returns a particular payment

                if ($payment->status == 'authorized') {
                    //TODO::change INR into default currency code
                    $payment->capture(array('amount' => $payment->amount, 'currency' => 'INR'));
                }

                $company = $this->company;

                $company->package_id = $plan->id;
                $company->package_type = $type;

                // Set company status active
                $company->status = 'active';
                $company->licence_expire_on = null;

                $company->save();

                $subscription = new RazorpaySubscription();

                $subscription->subscription_id = $subscriptionId;
                $subscription->company_id      = company()->id;
                $subscription->razorpay_id     = $paymentId;
                $subscription->razorpay_plan   = $type;
                $subscription->quantity        = 1;
                $subscription->save();

                //send superadmin notification
//                $superAdmin = User::whereNull('company_id')->get();
//                Notification::send($superAdmin, new CompanyUpdatedPlan($company, $plan->id));

                return Reply::redirect(route('admin.subscription'), 'Payment successfully done.');

            } catch (\Exception $e) {
                return back()->withError($e->getMessage())->withInput();
            }
        }
    }

    public function razorpaySubscription(Request $request){
        $credential = PaymentSetting::first();

        $plan = Package::find($request->plan_id);
        $type =  $request->type;

        $planID = ($type == 'annual') ? $plan->razorpay_annual_plan_id : $plan->razorpay_monthly_plan_id;

        $apiKey    = $credential->razorpay_key;
        $secretKey = $credential->razorpay_secret;

        $api        = new Api($apiKey, $secretKey);
        $subscription  = $api->subscription->create(array('plan_id' => $planID, 'customer_notify' => 1, 'total_count' => 2));

        return Reply::dataOnly(['subscriprion' => $subscription->id]);
    }

    public function razorpayInvoiceDownload($id)
    {
        $this->company = company();
        $this->invoice = RazorpayInvoice::with(['company','currency','package'])->findOrFail($id);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('razorpay-invoice.invoice-1', $this->data);
        $filename = $this->invoice->pay_date->format("dS M Y").'-'.$this->invoice->next_pay_date->format($this->global->date_format);
        return $pdf->download($filename . '.pdf');
    }
}
