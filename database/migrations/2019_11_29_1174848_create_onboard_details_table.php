<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnboardDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('on_board_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('job_application_id')->unsigned()->nullable()->default(null);
            $table->foreign('job_application_id')->references('id')->on('job_applications')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('designation_id')->unsigned()->nullable()->default(null);
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('department_id')->unsigned()->nullable()->default(null);
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('reports_to_id')->unsigned()->nullable()->default(null);
            $table->foreign('reports_to_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('salary_offered');
            $table->date('joining_date');
            $table->date('accept_last_date');
            $table->string('offer_code', 20)->nullable()->default(null);
            $table->string('sign')->nullable()->default(null);
            $table->string('reject_reason')->nullable()->default(null);
            $table->enum('hired_status', ['offered','accepted', 'rejected']);
            $table->enum('employee_status', ['part_time','full_time', 'on_contract']);

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
        Schema::dropIfExists('on_board_details');
    }
}
