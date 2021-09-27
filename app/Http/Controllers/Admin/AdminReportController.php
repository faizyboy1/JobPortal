<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\JobApplication;
use App\Job;

class AdminReportController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.reports');
        $this->pageIcon = 'icon-film';
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $this->jobApplication = JobApplication::count();
         $this->job = Job::count();
         $this->candidatesHired = JobApplication::where('status_id', 4)->count();
         $this->interviewScheduled = JobApplication::where('status_id', 3)->count();
         $data = [];
         $data['JobApplication'] = $this->jobApplication;
         $data['JobPosted'] = $this->job;
         $data['CandidatesHired'] = $this->candidatesHired;
         $data['InterviewScheduled'] = $this->interviewScheduled;
         $data1['chart_data'] = json_encode($data);
            
        return view('admin.report.index' ,$this->data,$data1);
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
