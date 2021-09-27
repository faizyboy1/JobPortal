<?php

use App\FooterSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFooterSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('social_links')->nullable();
            $table->string('footer_copyright_text')->nullable();
            $table->timestamps();
        });

        $footerSetting = new FooterSetting();

        $footerSetting->social_links = [
            ['name' => 'facebook', 'link' => 'https://facebook.com'],
            ['name' => 'twitter', 'link' => 'https://twitter.com'],
            ['name' => 'instagram', 'link' => 'https://instagram.com'],
            ['name' => 'dribbble', 'link' => 'https://dribbble.com']
        ];

        $footerSetting->footer_copyright_text = 'Copyright © 2020. All Rights Reserved';

        $footerSetting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('footer_settings');
    }
}
