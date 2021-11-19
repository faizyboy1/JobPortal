<?php

namespace App\Http\Controllers\Admin;

use App\ApplicationStatus;
use App\Helper\Reply;
use App\Traits\ZoomSettings;
use MacsiDigital\Zoom\Facades\Zoom;

use App\Http\Requests\InterviewSchedule\StoreRequest;
use App\Http\Requests\InterviewSchedule\UpdateRequest;
use App\InterviewSchedule;
use App\InterviewScheduleEmployee;
use App\JobApplication;
use App\Notifications\CandidateNotify;
use App\Notifications\CandidateReminder;
use App\Notifications\CandidateScheduleInterview;
use App\Notifications\EmployeeResponse;
use App\Notifications\ScheduleInterview;
use App\Notifications\ScheduleInterviewStatus;
use App\Notifications\ScheduleStatusCandidate;
use App\ScheduleComments;
use App\User;
use App\ZoomMeeting;
use App\ZoomSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\CandidateRejected;
use Illuminate\Support\Arr;

class InterviewScheduleController extends AdminBaseController
{
    Use ZoomSettings;
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.interviewSchedule';
        $this->pageIcon = 'icon-calender';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        abort_if(! $this->user->cans('view_schedule'), 403);

        $currentDate = Carbon::now($this->global->timezone)->format('Y-m-d'); // Current Date

        // Get All schedules
        $this->schedules = InterviewSchedule::
            select('interview_schedules.id', 'interview_schedules.job_application_id', 'interview_schedules.schedule_date', 'interview_schedules.status')
            ->with(['employees', 'jobApplication:id,job_id,full_name', 'jobApplication.job:id,title'])
            ->join('job_applications', 'job_applications.id','interview_schedules.job_application_id')
            ->whereNull('job_applications.deleted_at')
            ->where('status', 'pending')
            ->orderBy('schedule_date')
            ->get();

        // Filter upcoming schedule
        $upComingSchedules = $this->schedules->filter(function ($value, $key)use($currentDate) {
            return $value->schedule_date >= $currentDate;
        });

        $upcomingData = [];

        // Set array for upcoming schedule
        foreach($upComingSchedules as $upComingSchedule){
            $dt = $upComingSchedule->schedule_date->format('Y-m-d');
            $upcomingData[$dt][] = $upComingSchedule;
        }

        $this->upComingSchedules = $upcomingData;

        if($request->ajax()){
            $viewData = view('admin.interview-schedule.upcoming-schedule', $this->data)->render();
            return Reply::dataOnly(['data' => $viewData, 'scheduleData' => $this->schedules]);
        }

        return view('admin.interview-schedule.index', $this->data);
    }


    /**
     * @param Request $request
     * @return string
     * @throws \Throwable
     */
    public function create(Request $request){
        abort_if(! $this->user->cans('add_schedule'), 403);
        $this->zoom_setting = ZoomSetting::first();
        $this->candidates = JobApplication::all();
        $this->users = User::with('company')->company()->get();
        $this->scheduleDate = $request->date;
        return view('admin.interview-schedule.create', $this->data)->render();
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Throwable
     */
    public function table(Request $request){
        abort_if(! $this->user->cans('add_schedule'), 403);
        $this->candidates = JobApplication::all();
        $this->users = User::with('company')->company()->get();
        return view('admin.interview-schedule.table', $this->data);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function data(Request $request){
        abort_if(! $this->user->cans('view_schedule'), 403);

        $shedule = InterviewSchedule::select('interview_schedules.id','interview_schedules.interview_type','interview_schedule_employees.user_id as employee_id','zoom_meetings.start_link','job_applications.full_name','zoom_meetings.meeting_name','zoom_meetings.created_by','interview_schedules.status', 'interview_schedules.schedule_date')
            ->leftjoin('job_applications', 'job_applications.id', 'interview_schedules.job_application_id')
            ->leftjoin('interview_schedule_employees', 'interview_schedule_employees.interview_schedule_id', 'interview_schedules.id')
            ->leftjoin('zoom_meetings', 'zoom_meetings.id', 'interview_schedules.meeting_id')
            ->whereNull('job_applications.deleted_at');
            $this->zoomSetting = ZoomSetting::first();
        // Filter by status
        if($request->status != 'all' && $request->status != ''){
            $shedule = $shedule->where('interview_schedules.status', $request->status);
        }

        // Filter By candidate
        if($request->applicationID != 'all' && $request->applicationID != ''){
            $shedule = $shedule->where('job_applications.id', $request->applicationID);
        }

        // Filter by StartDate
        if($request->startDate !== null && $request->startDate != 'null'){
            $shedule = $shedule->where(DB::raw('DATE(interview_schedules.`schedule_date`)'), '>=', "$request->startDate");
        }

        // Filter by EndDate
        if($request->endDate !== null && $request->endDate != 'null'){
            $shedule = $shedule->where(DB::raw('DATE(interview_schedules.`schedule_date`)'), '<=', "$request->endDate");
        }

        return DataTables::of($shedule)
            ->addColumn('action', function ($row) {
                if ($this->zoomSetting->meeting_app == 'in_app') {
                    $url = $row->start_link;
                } else {
                    $url = $this->user->id == $row->created_by ? $row->start_link : $row->end_link;
                }
                $action = '';


                if( $this->user->cans('view_schedule')){
                    $action.= '<a href="javascript:;" data-row-id="' . $row->id . '" class="btn btn-info btn-circle view-data"
                      data-toggle="tooltip" data-original-title="'.__('app.view').'"><i class="fa fa-search" aria-hidden="true"></i></a>';
                }
                if( $this->user->cans('edit_schedule')){
                    $action.= '<a href="javascript:;" style="margin-left:4px" data-row-id="' . $row->id . '" class="btn btn-primary btn-circle edit-data"
                      data-toggle="tooltip" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                }

                if( $this->user->cans('delete_schedule')){
                    $action.= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }

                if ($row->interview_type == 'online' && $this->zoom_setting->status == 'active' && $this->user->id == $row->created_by && $row->employee_id == $this->user->id ) {
                    $action .= ' <a target="_blank" href="' . $url . '"  class="btn btn-success btn-circle fa fa-play "
                      data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="' . __('modules.zoommeeting.startMeeting') . '"><i class="fa fa-play"></i></a>';
                }
                return $action;
            })
            ->addColumn('checkbox', function ($row) {
                return '
                    <div class="checkbox form-check">
                        <input id="' . $row->id . '" type="checkbox" name="id[]" class="form-check-input" value="' . $row->id . '" >
                        <label for="' . $row->id . '"></label>
                    </div>
                ';
            })
            ->editColumn('full_name', function ($row) {
                return ucwords($row->full_name);
            })
            ->editColumn('schedule_date', function ($row) {
                return Carbon::parse($row->schedule_date)->format('d F, Y H:i a');
            })
            ->editColumn('status', function ($row) {
                if($row->status == 'pending'){
                    return '<label class="badge bg-warning">'.__('app.pending').'</label>';
                }
                if($row->status == 'hired'){
                    return '<label class="badge bg-success">'.__('app.hired').'</label>';
                }
                if($row->status == 'canceled'){
                    return '<label class="badge bg-danger">'.__('app.canceled').'</label>';
                }
                if($row->status == 'rejected'){
                    return '<label class="badge bg-danger">'.__('app.rejected').'</label>';
                }
            })
            ->rawColumns(['action', 'status', 'full_name', 'checkbox'])
            ->make(true);
    }

    /**
     * @param $id
     * @return string
     * @throws \Throwable
     */
    public function edit($id){
        abort_if(! $this->user->cans('edit_schedule'), 403);
        $this->zoom_setting = ZoomSetting::first();
        $this->candidates = JobApplication::all();
        $this->users = User::with('company')->company()->get();
        $this->schedule = InterviewSchedule::with(['jobApplication', 'user','meeting'])->find($id);
        $this->comment = ScheduleComments::where('interview_schedule_id', $this->schedule->id)
                                            ->where('user_id', $this->user->id)->first();
        $this->employeeList = json_encode($this->schedule->employee->pluck('user_id')->toArray());

        return view('admin.interview-schedule.edit', $this->data)->render();
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request){
        return Reply::dataOnly(["Candidate"=>$request->candidates]);
        abort_if(! $this->user->cans('add_schedule'), 403);
        $this->setZoomConfigs();
        $dateTime =  $request->scheduleDate.' '.$request->scheduleTime;
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $dateTime);

        foreach ($request->candidates as $candidateId) {
            if($request->interview_type == 'online'){

            $data = $request->all();
            $meeting = new ZoomMeeting();
            $data['meeting_name'] = $request->meeting_title;
            $data['start_date_time'] = $dateTime;
            $data['end_date_time'] = $request->end_date . ' ' . $request->end_time;
            $meeting = $meeting->create($data);
            $host = User::find($request->create_by);
            $user = Zoom::user()->find('me');
            $meetings = $this->createMeeting($user, $meeting,  null, $host);
         }
         else{
             $meetings = '';
         }

            // store Schedule
            $interviewSchedule = new InterviewSchedule();
            $interviewSchedule->job_application_id = $candidateId;
            $interviewSchedule->schedule_date = $dateTime;
            $interviewSchedule->interview_type = ($request->has('interview_type')) ? $request->interview_type : 'offline';
            $interviewSchedule->meeting_id = ($meetings!= '') ? $meetings->id: null;
            $interviewSchedule->save();

            $jobApplicationStatus = ApplicationStatus::where('status','interview')->first();
            // Update Schedule Status
            $jobApplication = $interviewSchedule->jobApplication;
            $jobApplication->status_id = $jobApplicationStatus->id;
            $jobApplication->save();

            if($request->comment){
                $scheduleComment = [
                    'interview_schedule_id' => $interviewSchedule->id,
                    'user_id' => $this->user->id,
                    'comment' => $request->comment
                ];
    
                $interviewSchedule->comments()->create($scheduleComment);
            }
            if(!empty($request->employees)){
                $interviewSchedule->employees()->attach($request->employees, ['company_id' => $this->user->company_id]);
                Notification::send($interviewSchedule->employees, new ScheduleInterview($jobApplication,$meetings));
            }
            // mail to candidate for inform interview schedule
            Notification::send($jobApplication, new CandidateScheduleInterview($jobApplication, $interviewSchedule,$meetings));
        }

        return Reply::redirect(route('admin.interview-schedule.index'), __('menu.interviewSchedule').' '.__('messages.createdSuccessfully'));
    }
    public function createMeeting($user, ZoomMeeting $meeting, $id, $meetingId = null, $host=null)
    {
        $this->setZoomConfigs();
        // create meeting using zoom API
        $commonSettings = [
            'type' => 2,
            'topic' => $meeting->meeting_name,
            'start_time' => $meeting->start_date_time,
            'duration' => $meeting->end_date_time->diffInMinutes($meeting->start_date_time),
            'timezone' => $this->global->timezone,
            'agenda' => $meeting->description,
            'alternative_host' => [],
            'settings' => [
                'host_video' => $meeting->host_video == 1,
                'participant_video' => $meeting->participant_video == 1,
            ]
        ];

        if($host){
            $commonSettings['alternative_host'] = [$host->email];
        }

        if (is_null($id)) {
            $zoomMeeting = $user->meetings()->make($commonSettings);
            $savedMeeting = $user->meetings()->save($zoomMeeting);

            $meeting->meeting_id = strval($savedMeeting->id);
            $meeting->start_link = $savedMeeting->start_url;
            $meeting->join_link = $savedMeeting->join_url;
            $meeting->password = $savedMeeting->password;

            $meeting->save();
        } else {
            $user->meetings()->find($meeting->meeting_id)->update($commonSettings);
        }

        return $meeting;
    }
    public function changeStatus(Request $request){
        abort_if(! $this->user->cans('add_schedule'), 403);

        $this->commonChangeStatusFunction($request->id, $request);

        return Reply::success(__('messages.interviewScheduleStatus'));
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @return array
     */
    public function update(UpdateRequest $request, $id){
        abort_if(! $this->user->cans('add_schedule'), 403);

        $this->setZoomConfigs();
        $dateTime =  $request->scheduleDate.' '.$request->scheduleTime;
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $dateTime);

        // Update interview Schedule
        $interviewSchedule = InterviewSchedule::select('id', 'job_application_id', 'schedule_date', 'status','meeting_id')
                            ->with([
                                'jobApplication:id,full_name,email,job_id,status_id',
                                'employees',
                                'comments'
                            ])
                            ->where('id', $id)->first();
        $interviewSchedule->schedule_date = $dateTime;
        $interviewSchedule->interview_type = ($request->has('interview_type')) ? $request->interview_type : 'offline';
        if($request->interview_type == 'offline'){
            $interviewSchedule->meeting_id = null;
            ZoomMeeting::where('id',$interviewSchedule->meeting_id)->delete();
            $meeting ='';
        }
        $interviewSchedule->save();

        if($request->comment){
            $scheduleComment = [
                'comment' => $request->comment
            ];

            $interviewSchedule->comments()->updateOrCreate([
                'interview_schedule_id' => $interviewSchedule->id,
                'user_id' => $this->user->id
            ], $scheduleComment);
        }

        $jobApplication = $interviewSchedule->jobApplication;
        //zoom meeting update
        $host = User::find($request->create_by);
        $user = Zoom::user()->find('me');
        if($request->interview_type == 'online'){

            $meeting = is_null($interviewSchedule->meeting_id) ? new ZoomMeeting() : ZoomMeeting::find($interviewSchedule->meeting_id);
            $data = $request->all();
            $data['meeting_name'] = $request->meeting_title;
            $data['start_date_time'] = $request->start_date . ' ' . $request->start_time;
            $data['end_date_time'] = $request->end_date . ' ' . $request->end_time;
            if (is_null($interviewSchedule->meeting_id)) {
                $meeting = $meeting->create($data);
            } else {
                $meeting->update($data);

            }
           $meetings = $this->createMeeting($user, $meeting, $interviewSchedule->meeting_id, null, $host);
            $interviewSchedule->meeting_id = $meetings->id;
            $interviewSchedule->save();
        }
        if(!empty($request->employee) || $request->interview_type == 'online'){
            $employees = [];
            if(!($request->interview_type)){
                $meeting = '';
            }
            foreach ($request->employee as $employee) {
                $employees = Arr::add($employees, $employee, ['company_id' => $this->user->company_id]);
            }
            
            $interviewSchedule->employees()->sync($employees);

            // Mail to employee for inform interview schedule
            Notification::send($interviewSchedule->employees, new ScheduleInterview($jobApplication,$meeting));
        }

        return Reply::redirect(route('admin.interview-schedule.index'), __('menu.interviewSchedule').' '.__('messages.updatedSuccessfully'));
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        abort_if(! $this->user->cans('delete_schedule'), 403);
        $meeting_id = InterviewSchedule::select('meeting_id')->where('id',$id)->get();
        InterviewSchedule::destroy($id);
        $this->setZoomConfigs();
        ZoomMeeting::destroy($meeting_id[0]->meeting_id);

        return Reply::success(__('messages.recordDeleted'));
    }

    /**
     * @param $id
     * @return string
     * @throws \Throwable
     */
    public function show(Request $request, $id)
    {
        abort_if(! $this->user->cans('view_schedule'), 403);
        $this->zoom_setting = ZoomSetting::first();
        $this->schedule = InterviewSchedule::with(['jobApplication', 'user'])->find($id);
        $this->currentDateTimestamp = Carbon::now(company()->timezone)->timestamp;
        $this->tableData = null;

        if($request->has('table')){
            $this->tableData = 'yes';
        }

        return view('admin.interview-schedule.show', $this->data)->render();
    }

    // notify and reminder to candidate on interview schedule
    public function notify($id, $type)
    {

        $jobApplication = JobApplication::find($id);

        if ($type == 'notify') {
            if ($jobApplication->status->status == 'hired') {
                // mail to candidate for hiring notify
                Notification::send($jobApplication, new CandidateNotify());
                return Reply::success(__('messages.notificationForHire'));
            }
            
            if ($jobApplication->status->status == 'rejected') {
                // mail to candidate for hiring notify
                Notification::send($jobApplication, new CandidateRejected());
                return Reply::success(__('messages.notificationForReject'));
            }
            
        } else {
            // mail to candidate for interview reminder
            Notification::send($jobApplication, new CandidateReminder( $jobApplication->schedule));
            return Reply::success(__('messages.notificationForReminder'));
        }

    }

    // Employee response on interview schedule
    public function employeeResponse($id, $res){

        $scheduleEmployee = InterviewScheduleEmployee::find($id);
        $meetings = ZoomMeeting::find( $scheduleEmployee->schedule->meeting_id);
        $users = User::allAdmins(); // Get All admins for mail
        $type = 'refused';

        if($res == 'accept'){  $type = 'accepted'; }

        $scheduleEmployee->user_accept_status = $res;

        // mail to admin for employee response on refuse or accept
        Notification::send($users, new EmployeeResponse($scheduleEmployee->schedule, $type, $this->user,$meetings));

        $scheduleEmployee->save();

        return Reply::success(__('messages.responseAppliedSuccess'));

    }

    public function changeStatusMultiple(Request $request){
        abort_if(! $this->user->cans('edit_schedule'), 403);
        foreach($request->id as $ids)
        {
            $this->commonChangeStatusFunction($ids, $request);
        }

        return Reply::success(__('messages.interviewScheduleStatus'));
    }

    public function commonChangeStatusFunction($id, $request)
    {
        // store Schedule
        $interviewSchedule = InterviewSchedule::select('id', 'job_application_id', 'status')
                            ->with([
                                'jobApplication:id,full_name,email,job_id,status_id',
                                'employees'
                            ])
                            ->where('id', $id)->first();
        $interviewSchedule->status = $request->status;
        $interviewSchedule->save();

        $application = $interviewSchedule->jobApplication;
        $status = ApplicationStatus::select('id', 'status');

        if(in_array($request->status, ['rejected', 'canceled'])){
            $applicationStatus = $status->status('rejected');
        }
        if($request->status === 'hired'){
            $applicationStatus = $status->status('hired');
        }
        if ($request->status === 'pending') {
            $applicationStatus = $status->status('interview');
        }

        $application->status_id = $applicationStatus->id;
        
        $application->save();

        $employees = $interviewSchedule->employees;
        $admins = User::allAdmins();

        $users = $employees->merge($admins);

        if($users){
            // Mail to employee for inform interview schedule
            Notification::send($users, new ScheduleInterviewStatus($application));
        }

        if($request->mailToCandidate ==  'yes'){
            // mail to candidate for inform interview schedule status
            Notification::send($application, new ScheduleStatusCandidate($application, $interviewSchedule));
        }

        return;
    }
}
