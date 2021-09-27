<?php

namespace App\Observers;

use App\Helper\Files;
use App\JobApplication;

class JobApplicationObserver
{
    public function saving(JobApplication $jobApplication)
    {
        if (company()) {
            $jobApplication->company_id = company()->id;
        }
    }

    public function updating(JobApplication $jobApplication){
        $original = $jobApplication->getOriginal();

        if ($jobApplication->isDirty('photo')){
            Files::deleteFile($original['photo'], 'candidate-photos');
        }
    }
}
