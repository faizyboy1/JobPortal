<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class JobOpeningHeading extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $compaines = \App\Company::all();
        foreach($compaines as $company){
            $company->job_opening_text  = __('modules.front.jobOpeningText');
            $company->job_opening_title = __('modules.front.homeHeader');
            $company->save();
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
