<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helper\Reply;
use App\Http\Requests\SmtpSetting\UpdateSmtpSetting;
use App\Http\Requests\UpdateProfile;
use App\EmailSetting;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class SuperAdminSmtpSettingController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.mailSetting';
        $this->pageIcon = 'ti-user';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $this->smtpSetting = EmailSetting::first();
        return view('super-admin.mail-setting.index', $this->data);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function update(UpdateSmtpSetting $request){


        $smtp = EmailSetting::first();

        $data = $request->all();

        if ($request->mail_encryption == "null" || $request->mail_encryption == "none") {
            $data['mail_encryption'] = null;
        }

        $smtp->update($data);
        $response = $smtp->verifySmtp();

        if ($smtp->mail_driver == 'mail') {
            return Reply::success(__('messages.updatedSuccessfully'));
        }

        if ($response['success']) {
            return Reply::success($response['message']);
        }
        // GMAIL SMTP ERROR
        $message = __('messages.smtpError').'<br><br> ';

        if ($smtp->mail_host == 'smtp.gmail.com')
        {
            $secureUrl = 'https://myaccount.google.com/lesssecureapps';
            $message .= __('messages.smtpSecureEnabled');
            $message .= '<a  class="font-13" target="_blank" href="' . $secureUrl . '">' . $secureUrl . '</a>';
            $message .= '<hr>' . $response['message'];
            return Reply::error($message);
        }

        return Reply::error($message . '<hr>' . $response['message']);

    }

    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        $smtp = EmailSetting::first();
        $response = $smtp->verifySmtp();

        if ($response['success']) {
            Notification::route('mail', \request()->test_email)->notify(new TestEmail());
            return Reply::success('Test mail sent successfully');
        }
        return Reply::error($response['message']);
    }

}
