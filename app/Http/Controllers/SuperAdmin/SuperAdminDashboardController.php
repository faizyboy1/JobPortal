<?php

namespace App\Http\Controllers\SuperAdmin;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use App\Company;
use App\Package;
use App\CompanyPackage;
use Illuminate\Support\Facades\DB;
use App\EmailSetting;
use App\PaymentSetting;

class SuperAdminDashboardController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageIcon = 'icon-speedometer';
        $this->pageTitle = 'menu.dashboard';
    }

    public function index()
    {
        $this->versionUpdate();

        $this->totalCompanies = Company::count();
        $this->totalPackages = Package::all()->count();
        $this->activeCompanies = Company::where('status', '=', 'active')->count();
        $this->inactiveCompanies = Company::where('status', '=', 'inactive')->count();
        $this->pendingRenewal = CompanyPackage::where('status', 'active')
            ->where(
                function ($query) {
                    $query->where(DB::raw('DATE(end_date)'), '<', DB::raw('CURDATE()'));
                }
            )
            ->count();

        $this->missingItems = 0;
        $totalItems = 2;
        $this->smtpSetting = EmailSetting::first();
        if ($this->smtpSetting->mail_from_email == 'your email') {
            $this->missingItems = $this->missingItems + 1;
        }
        $this->paymentSetting = PaymentSetting::first();
        if (is_null($this->paymentSetting->paypal_client_id) || is_null($this->paymentSetting->paypal_secret)) {
            $this->missingItems = $this->missingItems + 1;
        }
        $this->configCompletePercent = abs(((($this->missingItems/$totalItems) * 100) - 100));

        $this->packageData = Package::
        where(function($query){
            $query->where('monthly_price', '!=', 0);
            $query->orWhere('annual_price', '!=', 0);
        })
            ->where(function($query){
                $query->whereNull('stripe_annual_plan_id');
                $query->orWhereNull('stripe_monthly_plan_id');
            })
            ->first();

        return view('super-admin.dashboard.index', $this->data);
    }

    private function versionUpdate()
    {
        try {
            $client = new Client();
            $res = $client->request('GET', config('froiden_envato.updater_file_path'), ['verify' => false]);
            $lastVersion = $res->getBody();
            $lastVersion = json_decode($lastVersion, true);

            if ($lastVersion['version'] > File::get('version.txt')) {
                $this->lastVersion = $lastVersion['version'];
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

    }
}
