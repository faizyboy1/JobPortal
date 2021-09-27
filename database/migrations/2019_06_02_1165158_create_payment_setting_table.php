<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('payment_settings', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('paypal_client_id')->nullable()->default(null);
                $table->string('paypal_secret')->nullable()->default(null);
                $table->string('webhook_key')->nullable()->default(null);
                $table->enum('paypal_status', ['active', 'inactive'])->default('inactive');
                $table->enum('stripe_status', ['active', 'inactive'])->default('inactive');
                $table->timestamps();
            });

            $stripe = new \App\PaymentSetting();
            $stripe->paypal_client_id = null;
            $stripe->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_settings');

    }
}
