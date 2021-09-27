<?php

use App\Job;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRequiredColumnsColumnInJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->text('required_columns')->after('status');
        });

        $jobs = Job::select('id', 'title', 'required_columns')->get();

        $array = [
            'gender' => false,
            'dob' => false,
            'country' => false,
            // 'state' => false,
            // 'city' => false
        ];

        foreach ($jobs as $job) {
            $job->required_columns = $array;
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
            $table->dropColumn('required_columns');
        });
    }
}
