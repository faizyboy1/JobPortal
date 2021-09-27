<?php

use App\Company;
use App\Job;
use App\JobCompany;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJobCompanyIdInJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::table('jobs', function (Blueprint $table) {
                $table->unsignedInteger('job_company_id')->nullable()->after('company_id');
                $table->foreign('job_company_id')->references('id')->on('job_companies')->onDelete('cascade')->onUpdate('cascade');
            });

       $companies =  Company::all();
       foreach($companies as $company)
       {
           $jobCompany = new JobCompany();
           $jobCompany->company_id = $company->id;
           $jobCompany->company_name = $company->company_name;
           $jobCompany->save();

           $jobs = Job::withoutGlobalScope('company')->where('company_id', $company->id)->get();
           foreach($jobs as $job)
           {
            $job->job_company_id = $jobCompany->id;
            $job->save();
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
        Schema::table('jobs', function (Blueprint $table) {
            //
        });
    }
}
