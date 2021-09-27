<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helper\Reply;
use Illuminate\Http\Request;
use App\LinkedInSetting;
use Illuminate\Support\Str;

class LinkedInSettingController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.linkedInSettings';
        $this->pageIcon = 'icon-settings';
    }

    public function index(){
        $this->linkedInSetting = LinkedInSetting::first();
        $this->linkedInSetting->callback_url = route('jobs.linkedinCallback', 'linkedin');
        $this->httpsContains = Str::contains($this->linkedInSetting->callback_url, 'https');
        return view('super-admin.linked-in-settings.edit', $this->data);
    }

    public function update(Request $request, $id){
        /*dd($request->all());*/
        $setting = LinkedInSetting::findOrFail($id);
        $setting->client_id = $request->input('client_id');
        $setting->client_secret = $request->input('client_secret');
        $setting->callback_url = $request->input('callback_url');
        $setting->status = $request->input('status') == "on" ? 'enable' : 'disable';

        $setting->save();

        return Reply::redirect(route('superadmin.linkedin-settings.index'), __('menu.settings').' '.__('messages.updatedSuccessfully'));
    }

    public function updateStatus($id){
        $setting = LinkedInSetting::findOrFail($id);
        $setting->status = 'disable';

        $setting->save();
        return Reply::redirect(route('superadmin.linkedin-settings.index'), __('menu.settings').' '.__('messages.updatedSuccessfully'));
    }
}
