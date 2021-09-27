<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleRecaptchaKeyInGlobalSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->boolean('google_recaptcha_status')->default(false)->after('supported_until');
            $table->text('google_recaptcha_secret')->nullable()->after('google_recaptcha_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn('google_recaptcha_status');
            $table->dropColumn(['google_recaptcha_secret']);
        });
    }
}
