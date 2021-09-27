<?php

namespace App\Observers;

use App\ZoomSetting;

class ZoomSettingObserver
{

    public function saving(ZoomSetting $setting)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $setting->company_id = company()->id;
        }
    }

}
