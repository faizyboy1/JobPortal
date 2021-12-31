<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\InterviewSchedule;
use App\Job;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CandidateDashboardController extends CandidateBaseController
{
    public function getDate($string)
    {
        $date = explode(" ", $string);
        return $date[0];
    }
    public function index()
    {
        $this->activeJobs = DB::table('jobs')->where("status", "active")->get();
        $this->todayInterview = [];
        $this->interviewData = DB::table('interview_schedules')->get();
        for ($i = 0; $i < $this->interviewData->count(); $i++) {
            if ((explode(" ", $this->interviewData[$i]->schedule_date)[0]) == Carbon::now()->format('Y-m-d')) {
                $this->todayInterview = array_merge($this->todayInterview, [$this->interviewData[$i]]);
            }
        }

        // dd(Carbon::now()->toDateString() == '2021-11-10');

        // $user= auth()->user();
        return view('candidate.dashboard.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
