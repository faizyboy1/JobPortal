<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\FrontImageFeature;

class CreateFrontImageFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_image_features', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->mediumText('description');
            $table->string('image');
            $table->timestamps();
        });

        $feature = new FrontImageFeature();
        $feature->title = 'Applicant Tracking';
        $feature->description = 'From screening to hire, view the candidate status through each stage of the recruitment process. ';
        $feature->image = 'feature-1.png';
        $feature->save();

        $feature = new FrontImageFeature();
        $feature->title = 'Schedule Interviews';
        $feature->description = "Recruit's interview scheduler so you never miss out on a great hire";
        $feature->image = 'feature-2.png';
        $feature->save();

        $feature = new FrontImageFeature();
        $feature->title = 'Career Website';
        $feature->description = "A career website to advertise your jobs and let the candidates apply from it.";
        $feature->image = 'feature-3.png';
        $feature->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('front_image_features');
    }
}
