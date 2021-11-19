<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInSkillsResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::table('skills_resumes', function (Blueprint $table) {
            $table->bigInteger('candidate_resume_id')
                ->unsigned()->after('id')->nullable();
            $table->foreign('candidate_resume_id')->references('id')
                ->on('candidate_resumes')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skills_resumes', function (Blueprint $table) {
            //
        });
    }
}
