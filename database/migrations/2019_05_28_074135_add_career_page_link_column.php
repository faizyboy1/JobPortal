<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Company;

class AddCareerPageLinkColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('career_page_link')->unique()->nullable()->after('show_in_frontend');
        });

        $company = Company::first();
        $company->career_page_link = str_slug($company->company_name, '-');
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
            $table->dropUnique(['career_page_link']);
            $table->dropColumn(['career_page_link']);
        });
    }
}
