<?php

namespace App\Observers;

use App\InterviewScheduleEmployee;

class InterviewScheduleEmployeeObserver
{
    public function saving(InterviewScheduleEmployee $interviewScheduleEmployee)
    {
        if (company()) {
            $interviewScheduleEmployee->company_id = company()->id;
        }
    }
}
