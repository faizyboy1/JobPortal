<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('footer_menu_id');
            $table->foreign('footer_menu_id')->references('id')->on('footer_menu')->onDelete('cascade')->onUpdate('cascade');

            $table->string('seo_title')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_author')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_details');
    }
}
