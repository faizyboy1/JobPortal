<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\GlobalSetting;
use App\Currency;

class CreateGlobalSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_settings', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete(null)->onUpdate('cascade');
            
            $table->string('company_name');
            $table->string('company_email');
            $table->string('company_phone');
            $table->string('logo')->nullable();
            $table->text('address');
            $table->string('website')->nullable();
            $table->timestamps();
        });

        $currency =  Currency::first();

        $setting = new GlobalSetting();
        $setting->currency_id = $currency->id;
        $setting->company_name = 'Froiden';
        $setting->company_email = 'company@email.com';
        $setting->company_phone = '1234567891';
        $setting->address = 'Company address';
        $setting->website = 'www.domain.com';
        $setting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_settings');
    }
}
