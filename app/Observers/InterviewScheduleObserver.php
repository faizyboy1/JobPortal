<?php

namespace App\Observers;

use App\InterviewSchedule;

class InterviewScheduleObserver
{
    public function saving(InterviewSchedule $interviewSchedule)
    {
        if (company()) {
            $interviewSchedule->company_id = company()->id;
        }
    }
}
