<?php

use App\ApplicationSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMailSettingColumnInApplicationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_settings', function (Blueprint $table) {
            Schema::table('application_settings', function (Blueprint $table) {
                $table->text('mail_setting')->after('legal_term');
            });
    
            $applicationSetting = ApplicationSetting::select('id', 'mail_setting')->first();
    
            $applicationSetting->mail_setting = [
                '1' => [
                    'name' => 'applied',
                    'status' => true
                ],
                '2' => [
                    'name' => 'phone screen',
                    'status' => true
                ],
                '3' => [
                    'name' => 'interview',
                    'status' => true
                ],
                '4' => [
                    'name' => 'hired',
                    'status' => true
                ],
                '5' => [
                    'name' => 'rejected',
                    'status' => true
                ]
            ];
    
            $applicationSetting->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_settings', function (Blueprint $table) {
            $table->dropColumn('mail_setting');
        });
    }
}
