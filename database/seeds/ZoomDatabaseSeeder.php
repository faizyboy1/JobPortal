<?php

use App\ZoomSetting;
use Illuminate\Database\Seeder;
class ZoomDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies =  \App\Company::withoutGlobalScope('active')->get();
        foreach ($companies as $company) {
            $setting = ZoomSetting::where('company_id', $company->id)->first();
            if(is_null($setting)){
                $setting = new ZoomSetting();
                $setting->company_id = $company->id;
                $setting->save();
            }
        }
    }
}
