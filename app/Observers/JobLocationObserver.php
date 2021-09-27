<?php

namespace App\Observers;

use App\JobLocation;

class JobLocationObserver
{
    public function saving(JobLocation $jobLocation)
    {
        if (company()) {
            $jobLocation->company_id = company()->id;
        }
    }
}
