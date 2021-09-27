<?php

use App\ApplicationSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveProfileImageShowColumnFromApplicationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_settings', function (Blueprint $table) {
            $table->dropColumn('profile_image_show');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_settings', function (Blueprint $table) {
            $table->enum('profile_image_show', ['yes', 'no'])->default('no')->after('id');
        });
    }
}
