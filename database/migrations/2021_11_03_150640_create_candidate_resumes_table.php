<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_resumes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('profile_picture');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zip_code');
            $table->string('country_code');
            $table->bigInteger('phone');
            $table->string('email');
            $table->text('objective')->nullable();
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
        Schema::dropIfExists('candidate_resumes');
    }
}
