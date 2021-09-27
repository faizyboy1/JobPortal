<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helper\Files;
use App\Helper\Reply;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Company\StoreCompany;
use App\Job;
use App\Package;
use App\CompanyPackage;
use Carbon\Carbon;
use App\Http\Requests\Company\UpdatePakage;
use App\User;
use App\Role;
use App\Http\Requests\Company\UpdateCompany;
use Illuminate\Support\Facades\Auth;

class SuperAdminCompanyController extends SuperAdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.companies';
        $this->pageIcon = 'icon-film';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->totalCompanies = Company::withoutGlobalScope('company')->count();
        $this->activeCompanies = Company::withoutGlobalScope('company')->where('status', 'active')->count();
        $this->inactiveCompanies = Company::where('status', 'inactive')->count();
        return view('super-admin.company.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('super-admin.company.create', $this->data);
    }

    /**
     * @param StoreCompany $request
     * @return array
     */
    public function store(StoreCompany $request)
    {
        $setting = new Company();
        $setting->company_name        = $request->input('company_name');
        $setting->career_page_link    = str_slug($request->input('company_name'), '-');
        $setting->company_email       = $request->input('company_email');
        $setting->company_phone       = $request->input('company_phone');
        $setting->website             = $request->input('website');
        $setting->address             = $request->input('address');
        $setting->show_in_frontend    = $request->input('show_in_frontend');
        $setting->job_opening_text    = 'Welcome!';
        $setting->job_opening_title   = 'We want people to thrive. We believe you do your best work when you feel your best.';
        $setting->featured_start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $setting->featured_end_date   = Carbon::parse($request->end_date)->format('Y-m-d');
        $setting->featured            = ($request->featured == 'yes') ? 1 : 0;
        $setting->timezone            = 'Asia/Kolkata';
        if ($request->hasFile('logo')) {
            $setting->logo = Files::upload($request->logo,'company-logo');
        }
        if(module_enabled('Subdomain')){
            $setting->sub_domain = $request->sub_domain;
        }
        $setting->save();

        $user = new User();
        $user->company_id = $setting->id;
        $user->name = $request->full_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        //assign admin role to default user
        $role = Role::where('company_id', $setting->id)->first();
        $user->roles()->attach($role->id);

        return Reply::redirect(route('superadmin.company.index'), __('menu.companies') . ' ' . __('messages.createdSuccessfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->company = Company::withoutGlobalScope('company')->findOrFail($id);
        $this->companyPackage = CompanyPackage::activePackage($id);
        return view('super-admin.company.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->company = Company::withoutGlobalScope('company')->findOrFail($id);
        return view('super-admin.company.edit', $this->data);
    }

    /**
     * @param UpdateCompany $request
     * @param $id
     * @return array
     */
    public function update(UpdateCompany $request, $id)
    {
        $setting = Company::withoutGlobalScope('company')->findOrFail($id);

        $setting->company_name        = $request->input('company_name');
        $setting->company_email       = $request->input('company_email');
        $setting->company_phone       = $request->input('company_phone');
        $setting->website             = $request->input('website');
        $setting->address             = $request->input('address');
        $setting->show_in_frontend    = $request->input('show_in_frontend');
        $setting->featured_start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $setting->featured_end_date   = Carbon::parse($request->end_date)->format('Y-m-d');
        $setting->featured            = ($request->featured == 'yes') ? 1 : 0;

        if(module_enabled('Subdomain')){
            $setting->sub_domain = $request->sub_domain;
        }
        //update company's jobs status
        if ($setting->status != $request->input('status')) {
            Job::where('company_id', $id)->update(['status' => $request->status]);
        }

        $setting->status = $request->input('status');

        if ($request->hasFile('logo')) {
            $setting->logo = Files::upload($request->logo,'company-logo');
        }

        $setting->save();

        return Reply::redirect(route('superadmin.company.index'), __('menu.companies') . ' ' . __('messages.updatedSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $company = Company::withoutGlobalScope('company')->where('id', $id)->first();
        Files::deleteFile($company->logo, 'company-logo');
        $company->delete();

        return Reply::success(__('messages.recordDeleted'));
    }

    public function data()
    {
        $categories = Company::with('package')->withoutGlobalScope('company')->get();

        return DataTables::of($categories)
            ->addColumn('action', function ($row) {
                $action = '';

                $action .= '<a href="' . route('superadmin.company.show', [$row->id]) . '" class="btn btn-dark btn-circle"
                    data-toggle="tooltip" data-original-title="' . __('app.view') . '"><i class="fa fa-search" aria-hidden="true"></i></a>';

                $action .= ' <a href="' . route('superadmin.company.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                    data-toggle="tooltip" data-original-title="' . __('app.edit') . '"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                if(module_enabled('Subdomain')) {
                    $action .= ' <a href="javascript:;" class="btn btn-success btn-circle domain-params"
                      data-toggle="tooltip" data-company-id="' . $row->id . '" data-company-url="' . request()->getScheme().'//'.$row->sub_domain . '" data-original-title="Domain Notify to company admins"><i class="fa fa-bell" aria-hidden="true"></i></a>';
                }
                $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                    data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="' . __('app.delete') . '"><i class="fa fa-times" aria-hidden="true"></i></a>';
                return $action;
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'active') {
                    $status = '<label class="badge bg-success">' . __('app.active') . '</label>';


                    return $status;
                }
                if ($row->status == 'inactive') {
                    return '<label class="badge bg-danger">' . __('app.inactive') . '</label>';
                }
            })

            ->editColumn('logo', function ($row) {
                return '<img src="' . $row->logo_url . '" class="img-responsive" height="25" />';
            })
            ->editColumn('company_name', function ($row) {
                return '<a href="' . route("superadmin.company.show", [$row->id]) . '">' . ucfirst($row->company_name) . '</a>';
            })
            ->editColumn('package_id', function ($row) {
                $package = ucfirst($row->package->name);

                if (!$row->package->is_trial) {
                    $package .= '<br><small>[' . __('app.' . $row->package_type) . ']</small>';
                }

                if (!is_null($row->licence_expire_on) && $row->licence_expire_on->isPast()) {
                    $package .= '<br> <small class="text-danger">' . __("modules.subscription.packageExpired") . '</small>';
                }
                return $package;
            })
            ->editColumn('sub_domain', function ($row) {
                return '<a href="http://' . $row->sub_domain . '" target="_blank">' . $row->sub_domain . '</a>';
            })
            ->addIndexColumn()
            ->rawColumns(['logo', 'action', 'status', 'package_id', 'company_name','sub_domain'])
            ->make(true);
    }

    public function changePackage($companyId) {
        $this->packages = Package::where('is_trial', 0)->active()->get();
        $this->company = Company::withoutGlobalScope('company')->findOrFail($companyId);

        return view('super-admin.company.change_package_modal', $this->data);
    }

    public function updateCompanyPackage(UpdatePakage $request, $companyId) {
        CompanyPackage::where('company_id', $companyId)
            ->update(['status' => 'inactive', 'end_date' => Carbon::now()->format('Y-m-d')]);

        $company = Company::withoutGlobalScope('company')->findOrFail($companyId);
        $company->package_id = $request->package;

        $companyPackages = new CompanyPackage();
        $companyPackages->package_id = $request->package;
        $companyPackages->company_id = $companyId;
        $companyPackages->start_date = Carbon::now()->format('Y-m-d');
        if ($request->package_type) {
            $companyPackages->package_type = 'annual';
            $companyPackages->end_date = Carbon::now()->addYear()->format('Y-m-d');

            $company->package_type = 'annual';
            $company->licence_expire_on = Carbon::now()->addYear()->format('Y-m-d');
        } else {
            $companyPackages->package_type = 'monthly';
            $companyPackages->end_date = Carbon::now()->addMonth()->format('Y-m-d');

            $company->package_type = 'monthly';
            $company->licence_expire_on = Carbon::now()->addMonth()->format('Y-m-d');
        }
        $companyPackages->status = 'active';
        $companyPackages->save();

        $company->save();

        return Reply::success(__('messages.updatedSuccessfully'));

    }

    public function loginAsCompany($companyId)
    {
        $admin = User::frontAllAdmins($companyId)->first();

        Auth::logout();

        Auth::loginUsingId($admin->id);

        return Reply::success(__('messages.successfullyLoginAsCompany'));
    }
}
