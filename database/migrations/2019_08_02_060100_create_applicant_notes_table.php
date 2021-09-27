<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'applicant_notes', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('cascade');

                $table->integer('job_application_id')->unsigned();
                $table->foreign('job_application_id')->references('id')->on('job_applications')
                    ->onUpdate('cascade')->onDelete('cascade');

                $table->text('note_text');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_notes');
    }
}
