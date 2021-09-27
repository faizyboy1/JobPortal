<?php

use App\ApplicationSetting;
use App\Job;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddMetaDetailsAndSectionVisibilityColumnsInJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->text('meta_details')->after('required_columns');
            $table->text('section_visibility')->after('meta_details');
        });

        $setting = ApplicationSetting::select('id', 'profile_image_show')->first();

        $jobs = Job::select('id', 'title', 'job_description', 'meta_details')->get();
        foreach ($jobs as $job) {
            $job->meta_details = [
                'title' => $job->title,
                'description' => strip_tags(Str::substr(html_entity_decode($job->job_description), 0, 150))
            ];

            $job->section_visibility = [
                'profile_image' => $setting->profile_image_show,
                'resume' => 'yes',
                'cover_letter' => 'yes',
                'terms_and_conditions' => 'yes'
            ];

            $job->save();
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
            $table->dropColumn('meta_details');
            $table->dropColumn('section_visibility');
        });
    }
}
