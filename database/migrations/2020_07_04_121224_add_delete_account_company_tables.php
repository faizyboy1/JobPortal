<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeleteAccountCompanyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dateTime('delete_account_at')->nullable()->default(null);
        });

        Schema::table('global_settings', function (Blueprint $table) {
            $table->integer('delete_account_in')->nullable()->default(null);
            $table->enum('delete_account_hour_day', ['day','hour'])->default('hour');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['delete_account_at']);
        });
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn('delete_account_in');
            $table->dropColumn('delete_account_hour_day');
        });
    }
}
