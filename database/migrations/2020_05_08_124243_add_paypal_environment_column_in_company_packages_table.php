<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaypalEnvironmentColumnInCompanyPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_packages', function (Blueprint $table) {
            $table->string('paypal_environment')->nullable()->after('paypal_id');
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
            $table->dropColumn('paypal_enviroment');
        });
    }
}
