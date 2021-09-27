<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\FrontCmsHeader;

class CreateFrontCmsHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_cms_headers', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('description');
            $table->string('logo')->nullable();
            $table->string('header_image')->nullable();
            $table->string('header_background_color');
            $table->string('header_backround_image')->nullable();
            $table->boolean('show_login_in_menu', [true, false]);
            $table->boolean('show_register_in_menu', [true, false]);
            $table->boolean('show_login_in_header', [true, false]);
            $table->boolean('show_register_in_header', [true, false]);
            $table->longText('custom_css')->nullable();
            $table->text('call_to_action_title');
            $table->enum('call_to_action_button', ['login', 'register']);
            $table->mediumText('contact_text');
            $table->timestamps();
        });

        $frontCmsHeader = new FrontCmsHeader();
        $frontCmsHeader->title = 'Talent Acquisition Platform';
        $frontCmsHeader->description = 'Powerful software that makes hiring easy.';
        $frontCmsHeader->header_background_color = '#4a90e2';
        $frontCmsHeader->show_login_in_menu = true;
        $frontCmsHeader->show_register_in_menu = true;
        $frontCmsHeader->show_register_in_menu = true;
        $frontCmsHeader->show_login_in_header = false;
        $frontCmsHeader->show_register_in_header = true;
        $frontCmsHeader->call_to_action_title = 'Ready to get started?';
        $frontCmsHeader->contact_text = 'Give us a call or drop by anytime, we endeavour to answer all enquiries within 24 hours on business days.';
        $frontCmsHeader->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('front_cms_headers');
    }
}
