<?php

use App\FrontCmsHeader;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaDetailsColumnInFrontCmsHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('front_cms_headers', function (Blueprint $table) {
            $table->longText('meta_details')->after('contact_text');
        });

        $settings = FrontCmsHeader::select('id', 'meta_details')->first();

        $settings->meta_details = [
            'title' => 'Recruit – Recruitment Manager SAAS Version',
            'description' => 'Recruit is an application to manage the recruitment process of a company. If you are a company who need an application through which job seekers can apply directly on your website and you can manage those job applicants from an admin panel then this is the app you need.',
            'keywords' => ''
        ];

        $settings->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('front_cms_headers', function (Blueprint $table) {
            $table->dropColumn('meta_details');
        });
    }
}
