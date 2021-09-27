<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenderAgeCountryCityColumnsToJobApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('phone');
            $table->date('dob')->nullable()->after('gender');
            $table->string('country')->nullable()->after('dob');
            $table->string('state')->nullable()->after('country');
            $table->string('city')->nullable()->after('state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('dob');
            $table->dropColumn('country');
            $table->dropColumn('state');
            $table->dropColumn('city');
        });
    }
}
