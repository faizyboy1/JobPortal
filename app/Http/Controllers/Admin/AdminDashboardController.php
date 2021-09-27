<?php

namespace App\Http\Controllers\Admin;

use App\InterviewSchedule;
use App\Job;
use App\JobApplication;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageIcon = 'icon-speedometer';
        $this->pageTitle = 'menu.dashboard';
    }

    public function index()
    {
        $this->totalOpenings = Job::activeJobsCount();
   

        $allApplications = JobApplication::join('application_status', 'application_status.id', '=', 'job_applications.status_id')->get();

        $this->totalApplications = count($allApplications);
            
        $this->totalHired = $allApplications->filter(function ($value, $key) {
            return $value->slug  == 'hired';
        })->count();

        $this->totalRejected = $allApplications->filter(function ($value, $key) {
            return $value->slug  == 'rejected';
        })->count();

        $this->newApplications = $allApplications->filter(function ($value, $key) {
            return $value->slug  == 'applied';
        })->count();

        $this->shortlisted = $allApplications->filter(function ($value, $key) {
            return $value->slug  == 'phone screen' || $value->status == 'interview';
        })->count();
        
        $currentDate = Carbon::now(company()->timezone)->format('Y-m-d');

        $this->totalTodayInterview = InterviewSchedule::where(DB::raw('DATE(`schedule_date`)'),  "$currentDate")
            ->count();
        $this->todoItemsView = $this->generateTodoView();

        return view('admin.dashboard.index', $this->data);
    }
}
