<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CheckPaypalDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $payment = \App\PaymentSetting::first();
        if(!is_null($payment)){
            if(!is_null($payment->paypal_client_id) && !is_null($payment->paypal_secret)){
                $payment->paypal_status = 'active';
                $payment->save();
            }
            if(!is_null($payment->api_key) && !is_null($payment->api_secret) && !is_null($payment->webhook_key)){
                $payment->stripe_status = 'active';
                $payment->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
