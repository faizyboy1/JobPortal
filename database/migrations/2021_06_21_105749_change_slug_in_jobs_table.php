<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ChangeSlugInJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $compaines = \App\Company::all();
            foreach($compaines as $company){
                $jobs =\App\Job::whereNotNull('slug')->where('company_id', $company->id)->get();
                foreach($jobs as $job){
                    $job->slug =  $job->slug."-".Str::random(8);
                    $job->save();
                }

            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            //
        });
    }
}
