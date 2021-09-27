<?php

use App\JobApplication;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('documentable_id');
            $table->string('documentable_type');
            $table->string('name', 100);
            $table->string('hashname', 100);
            $table->timestamps();

            $table->unique(['company_id', 'documentable_id', 'documentable_type', 'name'], 'unique_document');
        });

        $applications = JobApplication::select('id', 'company_id', 'resume')->get();
        
        foreach ($applications as $application) {
            $application->documents()->create([
                'company_id' => $application->company_id,
                'name' => 'Resume',
                'hashname' => $application->resume
            ]);

            if (!is_dir(public_path('user-uploads/documents'))) {
                File::makeDirectory(public_path('user-uploads/documents'));
            }
            if (!is_dir(public_path('user-uploads/documents/'.$application->id))) {
                File::makeDirectory(public_path('user-uploads/documents/'.$application->id));
            }
            
            if (file_exists(public_path('user-uploads/resumes/'.$application->resume))) {
                File::move(public_path('user-uploads/resumes/'.$application->resume), public_path('user-uploads/documents/'.$application->id.'/'.$application->resume));
            }
        }

        File::deleteDirectory('user-uploads/resumes');

        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn('resume');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
