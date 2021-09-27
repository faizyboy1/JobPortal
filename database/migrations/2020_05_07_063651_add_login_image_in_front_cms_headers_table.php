<?php

use App\FrontCmsHeader;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoginImageInFrontCmsHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('front_cms_headers', function (Blueprint $table) {
            $table->string('login_background')->nullable();
            $table->string('register_background')->nullable();
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->string('login_background')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('front_cms_headers', function (Blueprint $table) {
            $table->dropColumn('login_background');
            $table->dropColumn('register_background');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('login_background');
        });
    }
}
