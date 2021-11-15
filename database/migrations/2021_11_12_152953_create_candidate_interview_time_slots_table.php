<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateInterviewTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_interview_time_slots', function (Blueprint $table) {
            $table->id();
            $table->integer('job_application_id')->unsigned();
            $table->foreign('job_application_id')->references('id')->on('job_applications')->onDelete('cascade');
            $table->string('time_slots');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_interview_time_slots');
    }
}
