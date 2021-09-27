<?php

namespace Modules\Zoom\Listeners;

use App\Events\CompanyRegistered;
use Modules\Zoom\Entities\ZoomSetting;

class NewZoomSettingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CompanyRegistered $event)
    {
        $company = $event->company;
        $fetchSetting = new ZoomSetting();
        $fetchSetting->company_id = $company->id;
        $fetchSetting->save();

    }
}
