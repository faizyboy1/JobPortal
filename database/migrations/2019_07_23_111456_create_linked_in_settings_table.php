<?php

use App\LinkedInSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkedInSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linked_in_settings', function (Blueprint $table) {
            $table->increments('id');

            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();
            $table->enum('status', ['enable', 'disable'])->default('disable');
            $table->string('callback_url')->nullable();
            $table->timestamps();
        });

        $setting = new LinkedInSetting();
        $setting->client_id = '';
        $setting->client_secret = '';
        $setting->status = 'disable';
        $setting->callback_url = '';
        $setting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linked_in_settings');
    }
}
