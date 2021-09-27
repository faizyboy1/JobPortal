<?php
namespace App\Traits;

use App\ZoomSetting;
use Illuminate\Support\Facades\Config;

trait ZoomSettings{
    public function setZoomConfigs(){
        $settings = ZoomSetting::first();
        $key       = ($settings->api_key)? $settings->api_key : env('ZOOM_KEY');
        $apiSecret = ($settings->secret_key)? $settings->secret_key : env('ZOOM_SECRET');

        Config::set('zoom.api_key', $key);
        Config::set('zoom.api_secret', $apiSecret);
    }
}



