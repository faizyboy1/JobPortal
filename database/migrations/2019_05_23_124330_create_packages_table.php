<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Package;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->float('monthly_price');
            $table->float('annual_price');
            $table->integer('no_of_job_openings')->nullable();  //set null for infinite
            $table->integer('no_of_candidate_access')->nullable(); //set null for infinite
            $table->boolean('career_website');
            $table->boolean('multiple_roles');
            $table->boolean('recommended');
            $table->boolean('is_trial');
            $table->boolean('status');
            $table->integer('trial_duration'); //In Days
            $table->timestamps();
        });

        $trialPackage = new Package();
        $trialPackage->name = 'Trial Package';
        $trialPackage->description = 'description';
        $trialPackage->monthly_price = 0;
        $trialPackage->annual_price = 0;
        $trialPackage->career_website = 1;
        $trialPackage->multiple_roles = 1;
        $trialPackage->is_trial = 1;
        $trialPackage->status = 1;
        $trialPackage->trial_duration = 14;
        $trialPackage->save();

        $package = new Package();
        $package->name = 'Professional';
        $package->description = 'description';
        $package->monthly_price = 20;
        $package->annual_price = 200;
        $package->career_website = 0;
        $package->multiple_roles = 0;
        $package->is_trial = 0;
        $package->status = 1;
        $package->no_of_job_openings = 4;
        $package->no_of_candidate_access = 100;
        $package->save();

        $package = new Package();
        $package->name = 'Expert';
        $package->description = 'description';
        $package->monthly_price = 40;
        $package->annual_price = 420;
        $package->career_website = 1;
        $package->multiple_roles = 1;
        $package->recommended = 1;
        $package->is_trial = 0;
        $package->no_of_job_openings = 10;
        $package->no_of_candidate_access = 500;
        $package->status = 1;
        $package->save();

        $package = new Package();
        $package->name = 'Corporate';
        $package->description = 'description';
        $package->monthly_price = 40;
        $package->annual_price = 420;
        $package->career_website = 1;
        $package->multiple_roles = 1;
        $package->is_trial = 0;
        $package->status = 1;
        $package->save();

       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
