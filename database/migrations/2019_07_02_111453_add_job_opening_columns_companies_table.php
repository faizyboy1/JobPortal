<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Company;

class AddJobOpeningColumnsCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->text('job_opening_title');
            $table->text('job_opening_text');
        });

        $company = Company::first();
        $company->job_opening_text = 'Welcome!';
        $company->job_opening_title = 'We want people to thrive. We believe you do your best work when you feel your best.';
        $company->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['job_opening_title']);
            $table->dropColumn(['job_opening_text']);
        });
    }
}
