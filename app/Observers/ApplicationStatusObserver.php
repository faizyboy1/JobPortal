<?php

namespace App\Observers;

use App\ApplicationStatus;

class ApplicationStatusObserver
{
    public function saving(ApplicationStatus $applicationStatus)
    {
        if (company()) {
            $applicationStatus->company_id = company()->id;
        }
    }
}
