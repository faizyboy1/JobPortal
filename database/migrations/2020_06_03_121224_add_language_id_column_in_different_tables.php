<?php

use App\LanguageSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageIdColumnInDifferentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $language = LanguageSetting::where('language_code', 'en')->first();
        Schema::table('front_cms_headers', function (Blueprint $table) use ($language) {
            $table->unsignedInteger('language_settings_id')->default($language->id)->after('id');
            $table->foreign('language_settings_id')->references('id')->on('language_settings')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('footer_menu', function (Blueprint $table) use ($language) {
            $table->unsignedInteger('language_settings_id')->default($language->id)->after('id');
            $table->foreign('language_settings_id')->references('id')->on('language_settings')->onUpdate('cascade')->onDelete('cascade');            
        });
        Schema::table('footer_settings', function (Blueprint $table) use ($language) {
            $table->unsignedInteger('language_settings_id')->default($language->id)->after('id');
            $table->foreign('language_settings_id')->references('id')->on('language_settings')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('front_image_features', function (Blueprint $table) use ($language) {
            $table->unsignedInteger('language_settings_id')->default($language->id)->after('id');
            $table->foreign('language_settings_id')->references('id')->on('language_settings')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('front_icon_features', function (Blueprint $table) use ($language) {
            $table->unsignedInteger('language_settings_id')->default($language->id)->after('id');
            $table->foreign('language_settings_id')->references('id')->on('language_settings')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('client_feedbacks', function (Blueprint $table) use ($language) {
            $table->unsignedInteger('language_settings_id')->default($language->id)->after('id');
            $table->foreign('language_settings_id')->references('id')->on('language_settings')->onUpdate('cascade')->onDelete('cascade');
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
            $table->dropForeign(['language_settings_id']);
            $table->dropColumn(['language_settings_id']);
        });
        Schema::table('footer_menu', function (Blueprint $table) {
            $table->dropForeign(['language_settings_id']);
            $table->dropColumn(['language_settings_id']);
        });
        Schema::table('footer_settings', function (Blueprint $table) {
            $table->dropForeign(['language_settings_id']);
            $table->dropColumn(['language_settings_id']);
        });
        Schema::table('front_image_features', function (Blueprint $table) {
            $table->dropForeign(['language_settings_id']);
            $table->dropColumn(['language_settings_id']);
        });
        Schema::table('front_icon_features', function (Blueprint $table) {
            $table->dropForeign(['language_settings_id']);
            $table->dropColumn(['language_settings_id']);
        });
        Schema::table('client_feedbacks', function (Blueprint $table) {
            $table->dropForeign(['language_settings_id']);
            $table->dropColumn(['language_settings_id']);
        });
    }
}
