<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helper\Reply;
use App\ThemeSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;

class SuperAdminThemeSettingsController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.themeSettings';
        $this->pageIcon = 'ti-settings';
    }

    public function index(){
        return view('super-admin.theme-settings.index', $this->data);
    }

    public function store(Request $request){
        $theme = ThemeSetting::whereNull('company_id')->first();
        $theme->primary_color = $request->primary_color;
        $theme->front_custom_css =  $request->front_custom_css;
        $theme->admin_custom_css =  $request->admin_custom_css;
        $theme->save();

        return Reply::redirect(route('superadmin.theme-settings.index'), __('menu.themeSettings').' '.__('messages.updatedSuccessfully'));
    }
    public function rtlTheme(Request $request)
    {
        $setting = ThemeSetting::whereNull('company_id')->first();
        $setting->rtl = $request->rtl ==  'true' ? 1 : 0;
        $setting->save();
        session()->forget('company_setting');
       return Reply::redirect(route('superadmin.theme-settings.index'), __('messages.updatedSuccessfully'));
    }
}
