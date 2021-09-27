<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInterviewTypeInInterviewSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interview_schedules', function (Blueprint $table) {
            $table->enum('interview_type', ['online', 'offline'])->default('offline')->after('status');
            $table->unsignedBigInteger('meeting_id')->nullable();
            $table->foreign('meeting_id')->references('id')->on('zoom_meetings')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interview_schedules', function (Blueprint $table) {
            $table->dropColumn(['interview_type']);
            $table->dropForeign(['meeting_id']);
            $table->dropColumn(['meeting_id']);
        });
    }
}
