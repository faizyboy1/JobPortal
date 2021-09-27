<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCompanyPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('company_packages', function (Blueprint $table) {
            $table->integer('stripe_id')->nullable()->default(null)->after('end_date');
            $table->integer('paypal_id')->nullable()->default(null)->after('stripe_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_packages', function (Blueprint $table) {
            $table->dropColumn('stripe_id');
            $table->dropColumn('paypal_id');
        });

    }
}
