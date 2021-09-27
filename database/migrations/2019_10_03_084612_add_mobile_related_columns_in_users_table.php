<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMobileRelatedColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('calling_code')->nullable()->after('email');
            $table->string('mobile')->nullable()->after('calling_code');
            $table->boolean('mobile_verified')->default(0)->after('mobile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('calling_code');
            $table->dropColumn('mobile');
            $table->dropColumn('mobile_verified');
        });
    }
}
