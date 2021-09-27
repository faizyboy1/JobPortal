<?php
/**
 * Created by PhpStorm.
 * User: DEXTER
 * Date: 24/05/17
 * Time: 11:29 PM
 */

namespace App\Traits;

// use App\CompanySetting;
// use App\GlobalSetting;
use App\SmsSetting;
use Illuminate\Notifications\NexmoChannelServiceProvider;
use Illuminate\Support\Facades\Config;

trait SmsSettings{

    public function setSmsConfigs(){
        // $settings = GlobalSetting::first();
        
        // $company = explode(' ',trim($settings->company_name));
        
        if (\config('app.env') !== 'development') {
            $smsSetting = SmsSetting::first();
            
            Config::set('services.nexmo.key', $smsSetting->nexmo_key);
            Config::set('services.nexmo.secret', $smsSetting->nexmo_secret);
            Config::set('services.nexmo.sms_from', $smsSetting->nexmo_from);
            
            Config::set('nexmo.api_key', $smsSetting->nexmo_key);
            Config::set('nexmo.api_secret', $smsSetting->nexmo_secret);
        }

        // Config::set('app.name', $company[0]);
        // Config::set('mail.from.name', $company[0]);

        (new NexmoChannelServiceProvider(app()))->register();
    }
}


