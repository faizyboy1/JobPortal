<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\ClientFeedback;

class CreateClientFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->text('feedback');
            $table->string('client_title');
            $table->timestamps();
        });

        $feedback = new ClientFeedback();
        $feedback->feedback = "We're crazy and obsessed with our hiring process, and Recruit caters exactly to what we need - optimize the shortest way to the best candidates.";
        $feedback->client_title = "Froiden - Head of HR";
        $feedback->save();

        $feedback = new ClientFeedback();
        $feedback->feedback = "Thanks to Recruit, we were easily able to bring all elements of our recruitment together in one place.";
        $feedback->client_title = "Tops - Recruitment Manager";
        $feedback->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_feedbacks');
    }
}
