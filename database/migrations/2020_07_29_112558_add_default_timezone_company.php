<?php

use App\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultTimezoneCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $companies = \App\Company::all();
        if ($companies) {
            foreach ($companies as $company) {

                if($company->timezone == null || $company->timezone == "" ) {
                    $company->timezone = 'Asia/Kolkata';
                    $company->save();
                }
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
