<?php

namespace App\Http\Controllers\Admin;

use App\CompanySetting;
use App\Helper\Files;
use App\Helper\Reply;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;

class CompanySettingsController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.companySettings';
        $this->pageIcon = 'icon-settings';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(! $this->user->cans('manage_settings'), 403);

        $this->timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        $setting = Company::findOrFail(company()->id);

        if(!$setting){
            abort(404);
        }

        return view('admin.settings.index', $this->data);
    }

    public function deleteAccount()
    {
        abort_if(! $this->user->cans('manage_settings'), 403);

        $setting = Company::findOrFail(company()->id);

        if(!$setting){
            abort(404);
        }

        return view('admin.delete-setting.edit', $this->data);
    }

    public function deleteAccountStore(Request $request)
    {
        abort_if(! $this->user->cans('manage_settings'), 403);

        $setting = Company::findOrFail($this->global->id);

        if($this->superSettings->delete_account_hour_day = 'day' && !is_null($this->superSettings->delete_account_in) && $this->superSettings->delete_account_in > 0)
        {
            $addableDate = Carbon::now()->addDays($this->superSettings->delete_account_in)->format('Y-m-d H:i');
        }
        else if($this->superSettings->delete_account_hour_day = 'hour' && !is_null($this->superSettings->delete_account_in) && $this->superSettings->delete_account_in > 0)
        {
            $addableDate = Carbon::now()->addHours($this->superSettings->delete_account_in)->format('Y-m-d H:i');
        }
        else{
            $addableDate = Carbon::now()->format('Y-m-d H:i');
        }

        if($request->type == 'cancel'){
            $setting->delete_account_at = null;
            $messages = __('messages.cancelDeleteAccountRequest');
        }
        else{
            $setting->delete_account_at = $addableDate;
            $messages = __('messages.deleteAccountRequest');
        }

        $setting->save();

        return Reply::redirect(route('admin.settings.delete-account'), $messages);
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
        abort_if(! $this->user->cans('manage_settings'), 403);

        $setting = Company::findOrFail($id);
        $setting->company_name      = $request->input('company_name');
        $setting->company_email     = $request->input('company_email');
        $setting->company_phone     = $request->input('company_phone');
        $setting->website           = $request->input('website');
        $setting->address           = $request->input('address');
        $setting->timezone          = $request->input('timezone');
        $setting->locale            = $request->input('locale');
        $setting->job_opening_text  = $request->input('job_opening_text');
        $setting->job_opening_title = $request->input('job_opening_title');
        $setting->career_page_link  = $request->input('slug');

        if ($request->hasFile('logo')) {
            $setting->logo = Files::upload($request->logo,'company-logo');
        }
        if ($request->hasFile('login_background')) {
            $setting->login_background = Files::upload($request->login_background,'login-background-image');
        }

        $setting->save();


        return Reply::redirect(route('admin.settings.index'));
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
}
