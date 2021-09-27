<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Files;
use App\Helper\Reply;
use App\ThemeSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminThemeSettingsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.themeSettings';
        $this->pageIcon = 'ti-settings';
    }

    public function index(){
        return view('admin.theme-settings.index', $this->data);
    }

    public function store(Request $request){
        $theme = ThemeSetting::where('company_id', '=', $this->global->id)->first();
        $theme->primary_color = $request->primary_color;
        $theme->front_custom_css =  $request->front_custom_css;
        $theme->admin_custom_css =  $request->admin_custom_css;

        $oldImage = $theme->home_background_image;

        if ($request->hasFile('image')) {
            $theme->home_background_image = Files::upload($request->image, 'background');

            $path = 'user-uploads/background' . '/' . $oldImage;

            if(\File::exists($path))
            {
                Files::deleteFile($oldImage, 'background');
            }
        }

        $theme->save();

        return Reply::redirect(route('admin.theme-settings.index'), __('menu.themeSettings').' '.__('messages.updatedSuccessfully'));
    }
    public function rtlTheme(Request $request)
    {
        $setting = ThemeSetting::where('company_id', '=', $this->global->id)->first();
        $setting->rtl = $request->rtl ==  'true' ? 1 : 0;
        $setting->save();
        session()->forget('company_setting');
       return Reply::redirect(route('admin.theme-settings.index'), __('messages.updatedSuccessfully'));
    }
}
