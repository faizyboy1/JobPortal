<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\ApplicationStatus;
use App\Role;
use App\ThemeSetting;
use App\User;
use App\Company;

class AddCompanyIdColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $company = Company::first();

        Schema::table('application_status', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        ApplicationStatus::whereNull('company_id')
            ->update(['company_id' => $company->id]);

        Schema::table('job_categories', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('job_locations', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Role::whereNull('company_id')
            ->update(['company_id' => $company->id]);

        Schema::table('theme_settings', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        ThemeSetting::whereNull('company_id')
            ->update(['company_id' => $company->id]);

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('interview_schedule_comments', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('interview_schedule_employees', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('interview_schedules', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('job_application_answers', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('job_applications', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('job_questions', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('job_skills', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        User::whereNull('company_id')
            ->update(['company_id' => $company->id]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
