<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Company;
use App\GlobalSetting;
use App\PaypalInvoice;
use App\RazorpayInvoice;
use App\StripeInvoice;
use App\Traits\StripeSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\SuperAdmin\StorePackage;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends SuperAdminBaseController
{
    use StripeSettings;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.invoices';
        $this->pageIcon = 'icon-settings';
    }

    public function index() {
        $stripeInvoices = DB::table("stripe_invoices")
            ->whereNotNull('stripe_invoices.pay_date')->count();

        $razorpayInvoice = DB::table("razorpay_invoices")
            ->whereNotNull('razorpay_invoices.pay_date')->count();

        $PaypalInvoices = DB::table("paypal_invoices")
            ->where('paypal_invoices.status', 'paid')->count();

        $this->totalInvoices = ($stripeInvoices + $PaypalInvoices + $razorpayInvoice);

        return view('super-admin.invoices.index', $this->data);
    }

    public function data() {
        $stripe = DB::table("stripe_invoices")
            ->join('packages', 'packages.id', 'stripe_invoices.package_id')
            ->join('companies', 'companies.id', 'stripe_invoices.company_id')
            ->selectRaw('stripe_invoices.id, stripe_invoices.invoice_id ,companies.company_name as company, 
            packages.name as package, stripe_invoices.transaction_id, "Stripe" as method,stripe_invoices.amount, 
            stripe_invoices.pay_date as paid_on ,stripe_invoices.next_pay_date')
            ->whereNotNull('stripe_invoices.pay_date');

        $razorpay = DB::table("razorpay_invoices")
            ->join('packages', 'packages.id', 'razorpay_invoices.package_id')
            ->join('companies', 'companies.id', 'razorpay_invoices.company_id')
            ->selectRaw('razorpay_invoices.id ,razorpay_invoices.invoice_id , companies.company_name as company,packages.name as name,
             razorpay_invoices.transaction_id,"Razorpay" as method,razorpay_invoices.amount, razorpay_invoices.pay_date as paid_on ,
             razorpay_invoices.next_pay_date')
            ->whereNotNull('razorpay_invoices.pay_date');

        $paypal = DB::table("paypal_invoices")
            ->join('packages', 'packages.id', 'paypal_invoices.package_id')
            ->join('companies', 'companies.id', 'paypal_invoices.company_id')
            ->selectRaw('paypal_invoices.id,"" as invoice_id, companies.company_name as company, 
                packages.name as package, paypal_invoices.transaction_id,
             "Paypal" as method , paypal_invoices.total as amount, paypal_invoices.paid_on,
             paypal_invoices.next_pay_date')
            ->where('paypal_invoices.status', 'paid')
            ->union($stripe)
            ->union($razorpay)
            ->get()->sortByDesc('paid_on');


        return DataTables::of($paypal)

            ->editColumn('company', function ($row) {
                return ucfirst($row->company);
            })
            ->editColumn('package', function ($row) {
                return ucfirst($row->package);
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
            ->editColumn('transaction_id', function ($row) {
                if(!is_null($row->transaction_id)) {
                    return $row->transaction_id;
                }
                return '-';
            })
            ->addColumn('action', function ($row) {
                if($row->method == 'Stripe' && $row->invoice_id){
                    return '<a href="'.route('superadmin.invoices.invoice-download', $row->invoice_id).'" class="btn btn-primary btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>';
                }
                if($row->method == 'Paypal'){
                    return '<a href="'.route('superadmin.invoices.paypal-invoice-download', $row->id).'" class="btn btn-primary btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>';
                }
                if($row->method == 'Razorpay'){
                    return '<a href="'.route('superadmin.invoices.razorpay-invoice-download', $row->id).'" class="btn btn-info btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>';
                }

                return '';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create() {
       //
    }

    public function store(StorePackage $request) {
       //
    }

    public function edit($id) {
       //
    }

    public function update($id) {
       //
    }

    public function destroy($id) {
//        Package::destroy($id);
//        return Reply::success(__('messages.recordDeleted'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function paypalInvoiceDownload($id)
    {
        $this->invoice = PaypalInvoice::with(['company','currency','package'])->findOrFail($id);

        $this->company = $this->invoice->company;
        $this->superSettings =  GlobalSetting::first();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('paypal-invoice.invoice-1', $this->data);
        $filename = $this->invoice->paid_on->format("dS M Y").'-'.$this->invoice->next_pay_date->format("dS M Y");
        return $pdf->download($filename . '.pdf');
    }

    /**
     * @param Request $request
     * @param $invoiceId
     * @return mixed
     */
    public function download(Request $request, $invoiceId) {
        $invoice = StripeInvoice::where('invoice_id', $invoiceId)->first();
        $this->company = Company::withoutGlobalScope('active')->where('id', $invoice->company_id)->first();
        $this->setStripConfigs();
        return $this->company->downloadInvoice($invoiceId, [
            'vendor'  => $this->company->company_name,
            'product' => $this->company->package->name,
            'global' => GlobalSetting::first(),
            'logo' => $this->company->logo,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function razorpayInvoiceDownload($id)
    {
        $this->invoice = RazorpayInvoice::with(['company','currency','package'])->findOrFail($id);
        $this->company = $this->invoice->company;
        $this->superSettings =  GlobalSetting::with('currency')->first();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('razorpay-invoice.invoice-1', $this->data);
        $filename = $this->invoice->pay_date->format("dS M Y").'-'.$this->invoice->next_pay_date->format($this->global->date_format);
        return $pdf->download($filename . '.pdf');
    }


}
