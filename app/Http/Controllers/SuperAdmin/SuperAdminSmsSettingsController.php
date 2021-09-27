<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helper\Reply;
use App\Http\Requests\SuperAdmin\SmsSetting\UpdateRequest;
use App\Package;
use App\SmsSetting;
use App\Traits\PaymentSettings;


class SuperAdminSmsSettingsController extends SuperAdminBaseController
{
    use PaymentSettings;

    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.sms.smsCredential';
        $this->pageIcon = 'icon-settings';
    }

    public function index() {
        $this->credentials = SmsSetting::first();
        return view('super-admin.sms-setting.index', $this->data);
    }

    public function update(UpdateRequest $request) {
        $smsSetting = SmsSetting::first();

        // Save SMS Credentials
        $smsSetting->nexmo_status = $request->nexmo_status;
        $smsSetting->nexmo_key = $request->nexmo_key;
        $smsSetting->nexmo_secret = $request->nexmo_secret;
        $smsSetting->nexmo_from = $request->nexmo_from;

        $smsSetting->save();
        
        return Reply::success(__('messages.updatedSuccessfully'));
    }
}
