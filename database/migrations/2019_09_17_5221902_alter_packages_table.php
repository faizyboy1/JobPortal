<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('packages', function (Blueprint $table) {
            $table->string('stripe_annual_plan_id', 255)->nullable()->default(null)->after('trial_duration');
            $table->string('stripe_monthly_plan_id', 255)->nullable()->default(null)->after('stripe_annual_plan_id');
            $table->unsignedTinyInteger('billing_cycle')->default(0)->after('stripe_monthly_plan_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('stripe_annual_plan_id');
            $table->dropColumn('stripe_monthly_plan_id');
            $table->dropColumn('billing_cycle');
        });

    }
}
