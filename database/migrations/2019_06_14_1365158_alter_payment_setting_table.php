<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPaymentSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->string('api_key')->nullable()->default(null)->after('paypal_secret');
            $table->string('api_secret')->nullable()->default(null)->after('api_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->dropColumn(['api_key']);
            $table->dropColumn(['api_secret']);
        });

    }
}
