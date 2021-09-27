<?php

namespace App\Observers;

use App\Job;
use Illuminate\Support\Str;

class JobObserver
{
    public function saving(Job $job)
    {
        $job->slug =  $job->slug ."-".Str::random(8);
    }
}
