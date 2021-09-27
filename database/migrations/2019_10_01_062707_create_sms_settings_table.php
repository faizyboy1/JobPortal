<?php

use App\SmsSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('nexmo_status', ['active', 'deactive'])->default('deactive');
            $table->string('nexmo_key')->nullable();
            $table->string('nexmo_secret')->nullable();
            $table->string('nexmo_from')->nullable()->default('NEXMO');
            $table->timestamps();
        });

        (new SmsSetting())->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_settings');
    }
}
