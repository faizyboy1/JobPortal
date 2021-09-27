<?php

namespace App\Observers;

use App\JobApplicationAnswer;
use App\User;

class JobApplicationAnswerObserver
{
    public function saving(JobApplicationAnswer $jobApplicationAnswer)
    {
        if (company()) {
            $jobApplicationAnswer->company_id = company()->id;
        }
    }
}
