<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\FrontIconFeature;

class CreateFrontIconFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_icon_features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->longText('description')->nullable()->default(null);
            $table->string('icon')->nullable()->default(null);
            $table->timestamps();
        });

        $feature = new FrontIconFeature();
        $feature->title = 'Social Media Integration';
        $feature->description = 'Share jobs on social media from career site.';
        $feature->icon = 'fas fa-share-alt';
        $feature->save();
        
        $feature = new FrontIconFeature();
        $feature->title = 'Export to excel';
        $feature->description = 'Export applicants in excel.';
        $feature->icon = 'far fa-file-excel';
        $feature->save();
        
        $feature = new FrontIconFeature();
        $feature->title = 'Quick Filters';
        $feature->description = 'Add quick filters to narrow your talent pool searches. ';
        $feature->icon = 'fas fa-filter';
        $feature->save();
        
        $feature = new FrontIconFeature();
        $feature->title = 'Applicant Rating';
        $feature->description = 'Quickly evaluate candidates with rating system.';
        $feature->icon = 'fas fa-star';
        $feature->save();
        
        $feature = new FrontIconFeature();
        $feature->title = 'Questionnaires';
        $feature->description = 'Create custom questionnaires for job application form.';
        $feature->icon = 'fas fa-edit';
        $feature->save();
        
        $feature = new FrontIconFeature();
        $feature->title = 'Flexible hiring roles';
        $feature->description = 'Assign flexible hiring roles to your team.';
        $feature->icon = 'fas fa-users';
        $feature->save();
        
        $feature = new FrontIconFeature();
        $feature->title = 'Theme Settings';
        $feature->description = 'Change logo and color of the app according to your branding.';
        $feature->icon = 'fas fa-paint-brush';
        $feature->save();
        
        $feature = new FrontIconFeature();
        $feature->title = 'Multiple Languages';
        $feature->description = 'Recruit is available in multiple languages';
        $feature->icon = 'fas fa-language';
        $feature->save();
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('front_icon_features');
    }
}
