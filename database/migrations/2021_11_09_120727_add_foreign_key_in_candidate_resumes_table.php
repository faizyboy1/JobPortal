<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInCandidateResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::table('candidate_resumes', function (Blueprint $table) {
            $table->integer('country_id')
                ->unsigned()->after('id')->nullable();
            $table->foreign('country_id')->references('id')
                ->on('countries')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidate_resumes', function (Blueprint $table) {
            //
        });
    }
}
