<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AlterCompanyFeatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('featured')->default(0);
            $table->date('featured_start_date')->nullable()->default(null);
            $table->date('featured_end_date')->nullable()->default(null);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('featured');
            $table->dropColumn('featured_start_date');
            $table->dropColumn('featured_end_date');
        });

    }
}
