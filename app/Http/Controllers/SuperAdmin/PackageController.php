<?php

namespace App\Http\Controllers\SuperAdmin;

use App\PaymentSetting;
use Illuminate\Http\Request;
use App\Package;
use App\Http\Requests\SuperAdmin\StorePackage;
use App\Helper\Reply;

class PackageController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.packages';
        $this->pageIcon = 'icon-settings';
    }

    public function index() {
        $this->packages = Package::all();
        $this->paymentSetting = PaymentSetting::first();
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
        return view('super-admin.packages.index', $this->data);
    }

    public function create() {
        $this->paymentSetting = PaymentSetting::first();
        return view('super-admin.packages.create', $this->data);
    }

    public function store(StorePackage $request) {
        $package = new Package();
        $package->name = $request->name;
        $package->description = $request->description;
        $package->monthly_price = $request->monthly_price;
        $package->annual_price = $request->annual_price;
        $package->is_private = $request->is_private;
        $package->stripe_monthly_plan_id = $request->stripe_monthly_plan_id;
        $package->stripe_annual_plan_id = $request->stripe_annual_plan_id;
        $package->razorpay_annual_plan_id = $request->razorpay_annual_plan_id;
        $package->razorpay_monthly_plan_id = $request->razorpay_monthly_plan_id;

        if ($request->no_of_job_openings != '') {
            $package->no_of_job_openings = $request->no_of_job_openings;
        } else {
            $package->no_of_job_openings = null;
        }

        if ($request->no_of_candidate_access != '') {
            $package->no_of_candidate_access = $request->no_of_candidate_access;
        } else {
            $package->no_of_candidate_access = null;
        }

        if ($request->career_website) {
            $package->career_website = 1;
        } else {
            $package->career_website = 0;
        }

        if ($request->multiple_roles) {
            $package->multiple_roles = 1;
        } else {
            $package->multiple_roles = 0;
        }

        if ($request->recommended) {
            $package->recommended = 1;
        } else {
            $package->recommended = 0;
        }

        if ($request->status) {
            $package->status = 1;
        } else {
            $package->status = 0;
        }
    
        $package->save();

        return Reply::redirect(route('superadmin.packages.index'), __('messages.createdSuccessfully'));
    }

    public function edit($id) {
        $this->package = Package::findOrfail($id);
        $this->paymentSetting = PaymentSetting::first();
        return view('super-admin.packages.edit', $this->data);
    }

    public function update(StorePackage $request, $id) {
        $package = Package::findOrFail($id);
        $package->name = $request->name;
        $package->description = $request->description;
        $package->monthly_price = $request->monthly_price;
        $package->annual_price = $request->annual_price;
        $package->is_private = $request->is_private;
        $package->stripe_monthly_plan_id = $request->stripe_monthly_plan_id;
        $package->stripe_annual_plan_id = $request->stripe_annual_plan_id;
        $package->razorpay_annual_plan_id = $request->razorpay_annual_plan_id;
        $package->razorpay_monthly_plan_id = $request->razorpay_monthly_plan_id;

        if ($request->no_of_job_openings != '') {
            $package->no_of_job_openings = $request->no_of_job_openings;
        } else {
            $package->no_of_job_openings = null;
        }

        if ($request->no_of_candidate_access != '') {
            $package->no_of_candidate_access = $request->no_of_candidate_access;
        } else {
            $package->no_of_candidate_access = null;
        }

        if ($request->trial_duration != '') {
            $package->trial_duration = $request->trial_duration;
        }

        if ($request->career_website) {
            $package->career_website = 1;
        } else {
            $package->career_website = 0;
        }

        if ($request->multiple_roles) {
            $package->multiple_roles = 1;
        } else {
            $package->multiple_roles = 0;
        }

        if ($request->recommended) {
            $package->recommended = 1;
        } else {
            $package->recommended = 0;
        }

        if ($request->status) {
            $package->status = 1;
        } else {
            $package->status = 0;
        }
    
        $package->save();

        return Reply::redirect(route('superadmin.packages.index'), __('messages.updatedSuccessfully'));
    }

    public function destroy($id) {
        Package::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }


}
