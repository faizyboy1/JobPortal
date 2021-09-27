<?php
/**
 * Created by PhpStorm.
 * User: DEXTER
 * Date: 24/05/17
 * Time: 11:29 PM
 */

namespace App\Traits;

use App\EmailSetting;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Support\Facades\Config;
use App\GlobalSetting;

trait SmtpSettings{

    public function setMailConfigs(){
        $smtpSetting = EmailSetting::first();
        $settings = GlobalSetting::first();
        $company = company();
        $companyName = $company ? $company->company_name : $smtpSetting->mail_from_name;
        $companyEmail = $company ? $company->company_email : $smtpSetting->mail_from_email;
        $company = explode(' ', trim($settings->company_name));

        if (\config('app.env') !== 'development') {
            Config::set('mail.driver', $smtpSetting->mail_driver);
            Config::set('mail.host', $smtpSetting->mail_host);
            Config::set('mail.port', $smtpSetting->mail_port);
            Config::set('mail.username', $smtpSetting->mail_username);
            Config::set('mail.password', $smtpSetting->mail_password);
            Config::set('mail.encryption', $smtpSetting->mail_encryption);
            Config::set('mail.from.name', $smtpSetting->mail_from_name); 
            Config::set('mail.from.address', $smtpSetting->mail_from_email);  
        }

        Config::set('mail.reply_to.name', $companyName);
        Config::set('mail.reply_to.address', $companyEmail);
        Config::set('mail.from.name', $companyName);

         if (\config('mail.verified') === true) {
             Config::set('mail.from.address', $smtpSetting->mail_from_email);
         } else {
             Config::set('mail.from.address', $companyEmail);
         }
        Config::set('app.name', $companyName);
//        Config::set('mail.from.name', $company[0]);

        (new MailServiceProvider(app()))->register();
    }

}
