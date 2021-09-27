<?php

use App\LanguageSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnglishRowInLanguageSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('language_settings', function (Blueprint $table) {
            $reqLanguage = LanguageSetting::where('language_code', 'en')->first();
            if (!$reqLanguage) {
                $language = new LanguageSetting();

                $language->language_name = 'English';
                $language->language_code = 'en';
                $language->status = 'enabled';

                $language->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('language_settings', function (Blueprint $table) {
            $reqLanguage = LanguageSetting::where('language_code', 'en')->first();
            if ($reqLanguage) {
                $reqLanguage->delete();
            }
        });
    }
}
