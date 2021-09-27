<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Currency;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('currency_name');
            $table->string('currency_symbol');
            $table->string('currency_code');
            $table->timestamps();
        });

        $currency = new Currency();
        $currency->currency_name = 'Dollars';
        $currency->currency_symbol = '$';
        $currency->currency_code = 'USD';
        $currency->save();

        $currency = new Currency();
        $currency->currency_name = 'Pounds';
        $currency->currency_symbol = '£';
        $currency->currency_code = 'GBP';
        $currency->save();

        $currency = new Currency();
        $currency->currency_name = 'Euros';
        $currency->currency_symbol = '€';
        $currency->currency_code = 'EUR';
        $currency->save();

        $currency = new Currency();
        $currency->currency_name = 'Rupee';
        $currency->currency_symbol = '₹';
        $currency->currency_code = 'INR';
        $currency->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
