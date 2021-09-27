<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnboardfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('on_board_files', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('on_board_detail_id')->unsigned()->nullable()->default(null);
            $table->foreign('on_board_detail_id')->references('id')->on('on_board_details')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('name');
            $table->string('file');
            $table->string('hash_name');
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
        Schema::dropIfExists('on_board_files');
    }
}
