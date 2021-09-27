<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewJobEmailStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_job_application', function (Blueprint $table) {
            $table->unsignedInteger('job_application_id');
            $table->unsignedInteger('job_id');
            $table->foreign('job_application_id')->references('id')->on('job_applications')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_job_application');
    }
}
