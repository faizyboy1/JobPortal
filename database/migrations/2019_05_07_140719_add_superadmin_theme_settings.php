<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\ThemeSetting;

class AddSuperadminThemeSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $theme = new ThemeSetting();
        $theme->primary_color = '#1579d0';
        $theme->admin_custom_css = '/*Enter your custom css after this line*/ 
        .sidebar-dark-primary {
           background-image: linear-gradient(to top, #00c6fb 0%, #005bea 100%);
        }';
        $theme->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('theme_settings', function (Blueprint $table) {
            //
        });
    }
}
