<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helper\Files;
use App\Helper\Reply;
use App\LanguageSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\Setting\StoreRequest;
use App\Company;
use App\GlobalSetting;
use App\Currency;

class GlobalSettingController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.settings';
        $this->pageIcon = 'icon-settings';
    }

    public function index(){
        $this->currencies = Currency::all();
        return view('super-admin.global-settings.edit', $this->data);
    }

    public function update(StoreRequest $request,$id){
        $setting = GlobalSetting::first();
        $setting->company_name = $request->input('company_name');
        $setting->company_email = $request->input('company_email');
        $setting->company_phone = $request->input('company_phone');
        $setting->website = $request->input('website');
        $setting->address = $request->input('address');
        $setting->currency_id = $request->input('currency_id');
        $setting->locale = $request->input('locale');
        $setting->system_update = $request->has('system_update') && $request->input('system_update') == 'on' ? 1 : 0;;
        $setting->delete_account_hour_day = $request->has('hoursDays');
        $setting->delete_account_in = $request->has('delete_account_in');

        if($request->has('google_recaptcha_status') && $request->google_recaptcha_status == 'on'){
            $setting->google_recaptcha_status = '1';
            $setting->google_recaptcha_secret = $request->input('google_recaptcha_secret');
            $setting->google_recaptcha_key = $request->input('google_recaptcha_key');
        }  else{
            $setting->google_recaptcha_status = '0';
            $setting->google_recaptcha_secret = $request->input('');
            $setting->google_recaptcha_key = $request->input('');
        }

        if ($request->hasFile('logo')) {
            Files::deleteFile($setting->logo,'global-logo');
            $setting->logo = Files::upload($request->logo,'global-logo');
        }

        $setting->save();

        return Reply::redirect(route('superadmin.global-settings.index'), __('menu.settings').' '.__('messages.updatedSuccessfully'));
    }

    public function changeLanguage(Request $request) {
        $setting = Company::first();
        $setting->locale = $request->input('lang');
        $setting->save();

        return Reply::success('Language changed successfully.');
    }
}
