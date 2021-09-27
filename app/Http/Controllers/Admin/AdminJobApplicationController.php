<?php

namespace App\Http\Controllers\Admin;

use App\ApplicationSetting;
use App\ApplicationStatus;
use MacsiDigital\Zoom\Facades\Zoom;
use App\ZoomMeeting;
use App\ZoomSetting;
use App\Traits\ZoomSettings;
use App\Company;
use App\Exports\JobApplicationExport;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\InterviewSchedule\StoreRequest;
use App\Http\Requests\StoreJobApplication;
use App\Http\Requests\UpdateJobApplication;
use App\InterviewSchedule;
use App\Job;
use App\JobApplication;
use App\JobApplicationAnswer;
use App\JobLocation;
use App\Notifications\CandidateScheduleInterview;
use App\Notifications\CandidateStatusChange;
use App\Notifications\ScheduleInterview;
use App\Skill;
use App\User;
use App\JobCompany;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;


class AdminJobApplicationController extends AdminBaseController
{
    Use ZoomSettings;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.jobApplications';
        $this->pageIcon = 'icon-user';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!$this->user->cans('view_job_applications'), 403);
        $date = Carbon::now(company()->timezone);
        $startDate = $date->subDays(30)->format('Y-m-d');
        $endDate = Carbon::now(company()->timezone)->format('Y-m-d');
        $this->locations = JobLocation::all();
        $this->jobs = Job::where('company_id', company()->id)->get();
        $this->jobCompanies = JobCompany::all();
        $this->boardColumns = ApplicationStatus::with(['applications' => function ($q) use ($startDate, $endDate, $request) {

            if ($request->startDate !== null && $request->startDate != 'null' && $request->startDate != '') {
                $q = $q->where(DB::raw('DATE(job_applications.`created_at`)'), '>=', $request->startDate);
            } else {
                $q = $q->where(DB::raw('DATE(job_applications.`created_at`)'), '>=', $startDate);
            }

            if ($request->endDate !== null && $request->endDate != 'null' && $request->endDate != '') {
                $q = $q->where(DB::raw('DATE(job_applications.`created_at`)'), '<=', $request->endDate);
            } else {
                $q = $q->where(DB::raw('DATE(job_applications.`created_at`)'), '<=', $endDate);
            }
            if ($request->jobCompany != 'all' && $request->jobCompany != '') {
                $q = $q->Join('jobs','jobs.id', 'job_applications.job_id')
                          ->Join('job_companies','job_companies.id', 'jobs.job_company_id')
                          ->where('jobs.job_company_id', $request->jobCompany);
            }
            // Filter By jobs
            if ($request->jobs != 'all' && $request->jobs != '' &&  $request->jobs != 'null') {
                $q = $q->where('job_applications.job_id', $request->jobs);
            }
            // Filter By jobs
            if ($request->search != null && $request->search != '') {
                $q = $q->where('full_name', 'LIKE', '%' . $request->search . '%');
            }

        }, 'applications.schedule'])->orderBy('position')->get();

        $boardStracture = [];
        foreach ($this->boardColumns as $key => $column) {
            $boardStracture[$column->id] = [];
            foreach ($column->applications as $application) {
                $boardStracture[$column->id][] = $application->id;
            }
        }
        $this->boardStracture =  json_encode($boardStracture);
        $this->currentDate = Carbon::now(company()->timezone)->timestamp;

        $this->startDate = $startDate;
        $this->endDate = $endDate;

        if ($request->ajax()) {
            $view = view('admin.job-applications.board-data', $this->data)->render();
            return Reply::dataOnly(['view' => $view]);
        }

        $this->mailSetting = ApplicationSetting::select('id', 'mail_setting')->first();

        return view('admin.job-applications.board', $this->data);
    }

    public function create()
    {
        abort_if(!$this->user->cans('add_job_applications'), 403);

        $candidateCount = JobApplication::count();
            if($candidateCount > 0 && $this->activePackage->package->no_of_candidate_access !== null && $this->activePackage->package->no_of_candidate_access <= $candidateCount) {
            $this->message = __('modules.subscription.candidatePurchase');
            return view('admin.subscription.ask_purchase', $this->data);
        }
        $this->jobs = Job::activeJobs();
        $this->gender = [
            'male' => __('modules.front.male'),
            'female' => __('modules.front.female'),
            'others' => __('modules.front.others')
        ];
        return view('admin.job-applications.create', $this->data);
    }

    /**
     * @param $jobID
     * @return mixed
     * @throws \Throwable
     */
    public function jobQuestion($jobID, $applicationId = null)
    {
        $this->job = Job::findOrFail($jobID);
        $this->jobQuestion = $this->job->questions()->with([
            'answers' => function ($query) use ($jobID, $applicationId){
                $query->where(['job_application_id' => $applicationId, 'job_id' => $jobID]);
            }
        ])->get();
        $this->gender = [
            'male' => __('modules.front.male'),
            'female' => __('modules.front.female'),
            'others' => __('modules.front.others')
        ];

        $view = view('admin.job-applications.job-question', $this->data)->render();

        $options = ['job' => $this->job, 'gender' => $this->gender];
        $sections = ['section_visibility' => $this->job->section_visibility];

        if ($applicationId) {
            $application = JobApplication::select('id', 'gender', 'dob', 'country', 'state', 'city')->where('id', $applicationId)->first();

            $options = Arr::add($options, 'application', $application);
            $sections = Arr::add($sections, 'application', $application);
        }
        $requiredColumnsView = view('admin.job-applications.required-columns', $options)->render();
        $requiredSectionsView = view('admin.job-applications.required-sections', $sections)->render();
        
        $count = count($this->jobQuestion);
        
        $data = ['status' => 'success', 'view' => $view, 'requiredColumnsView' => $requiredColumnsView, 'requiredSectionsView' => $requiredSectionsView, 'count' => $count];
        
        if ($applicationId) {
            $data = Arr::add($data, 'application', $application);
        }

        return Reply::dataOnly($data);
    }


    public function edit($id)
    {
        abort_if(!$this->user->cans('edit_job_applications'), 403);

        $this->statuses = ApplicationStatus::all();
        $this->application = JobApplication::find($id);
        $this->jobQuestion = $this->application->job->questions;
        $this->jobs = Job::select('id', 'title', 'location_id', 'status', 'start_date', 'end_date', 'section_visibility')->with('location:id,location')->get();

        return view('admin.job-applications.edit', $this->data);
    }

    public function data(Request $request)
    {
        abort_if(!$this->user->cans('view_job_applications'), 403);

        $jobApplications = JobApplication::select('id', 'job_id', 'status_id', 'full_name', 'skills')
            ->with([
                'job:id,location_id,title',
                'job.skills',
                'job.location:id,location',
                'status:id,status,color'
            ]);
        
        // Filter by status
        if ($request->status != 'all' && $request->status != '') {
            $jobApplications = $jobApplications->where('status_id', $request->status);
        }
        
        // Filter By jobs
        if ($request->jobs != 'all' && $request->jobs != '') {
            $jobApplications = $jobApplications->where('job_id', $request->jobs);
        }

        // Filter By skills
        if ($request->skill != 'all' && $request->skill != '') {
            foreach (explode(',', $request->skill) as $key => $skill) {
                if ($key == 0) {
                    $jobApplications = $jobApplications->whereJsonContains('skills', $skill);
                }
                else {
                    $jobApplications = $jobApplications->orWhereJsonContains('skills', $skill);
                }
            }
        }
        
        // Filter by location
        if ($request->location != 'all' && $request->location != '') {
            $jobApplications = $jobApplications->whereHas('job.location', function ($query) use ($request)
            {
                $query->where('id', $request->location);
            });
        }

        // Filter by StartDate
        if ($request->startDate != null && $request->startDate != '') {
            $jobApplications = $jobApplications->whereDate('created_at', '>=', $request->startDate);
        }

        // Filter by EndDate
        if ($request->endDate != null && $request->endDate != '') {
            $jobApplications = $jobApplications->whereDate('created_at', '<=', $request->endDate);
        }
        $jobApplications = $jobApplications->get();

        return DataTables::of($jobApplications)
            ->addColumn('action', function ($row) {
                $action = '';
                
                if ($this->user->cans('view_job_applications')) {
                    $action .= '<a href="javascript:;" class="btn btn-success btn-circle show-document"
                      data-toggle="tooltip" data-row-id="' . $row->id . '" data-modal-name="' . '\\' . get_class($row) . '" data-original-title="' . __('modules.jobApplication.viewDocuments') . '"><i class="fa fa-search" aria-hidden="true"></i></a>';
                }

                if ($this->user->cans('edit_job_applications')) {
                    $action .= ' <a href="' . route('admin.job-applications.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                      data-toggle="tooltip" data-original-title="' . __('app.edit') . '"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                }

                if ($this->user->cans('delete_job_applications')) {
                    $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="' . __('app.delete') . '"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }
                return $action;
            })
            ->editColumn('full_name', function ($row) {
                return '<a href="javascript:;" class="show-detail" data-widget="control-sidebar" data-slide="true" data-row-id="' . $row->id . '">' . ucwords($row->full_name) . '</a>';
            })
            ->editColumn('title', function ($row) {
                return ucfirst($row->job->title);
            })
            ->editColumn('location', function ($row) {
                return ucwords($row->job->location->location);
            })
            ->editColumn('status', function ($row) {
                return '<span>' . ucwords($row->status->status) .'</span>
                 <span class="badge badge-pill badge-primary text-white" style= "margin-bottom: -3px; height: 15px; background:' . $row->status->color . '"> </span>';
                //return ucwords($row->status->status);
            })
            ->rawColumns(['action', 'full_name','status'])
            ->addIndexColumn()
            ->make(true);
    }

    public function createSchedule(Request $request, $id)
    {
        abort_if(!$this->user->cans('add_schedule'), 403);
        $this->zoom_setting = ZoomSetting::first();
        $this->candidates = JobApplication::all();
        $this->users = User::with('company')->company()->get();
        $this->scheduleDate = $request->date;
        $this->currentApplicant = JobApplication::findOrFail($id);
        return view('admin.job-applications.interview-create', $this->data)->render();
    }

    public function storeSchedule(StoreRequest $request)
    {
        abort_if(!$this->user->cans('add_schedule'), 403);
        $this->setZoomConfigs();

        $dateTime =  $request->scheduleDate . ' ' . $request->scheduleTime;
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $dateTime);
        //store zoom meeting
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
        $interviewSchedule->interview_type =$request->interview_type;
        $interviewSchedule->meeting_id = ($meetings!= '') ? $meetings->id: null;
        $interviewSchedule->job_application_id = $request->candidates[0];
        $interviewSchedule->schedule_date = $dateTime;
        $interviewSchedule->save();

        // Update Schedule Status
        $status = ApplicationStatus::where('status', 'interview')->first();
        $jobApplication = $interviewSchedule->jobApplication;

        $jobApplication->status_id = $status->id;

        $jobApplication->save();

        if($request->comment){
            $scheduleComment = [
                'interview_schedule_id' => $interviewSchedule->id,
                'user_id' => $this->user->id,
                'comment' => $request->comment
            ];

            $interviewSchedule->comments()->create($scheduleComment);
        }

        if (!empty($request->employees)) {
            $interviewSchedule->employees()->attach($request->employees, ['company_id' => $this->user->company_id]);

            // Mail to employee for inform interview schedule
            Notification::send($interviewSchedule->employees, new ScheduleInterview($jobApplication,$meetings));
        }

        // mail to candidate for inform interview schedule
        Notification::send($jobApplication, new CandidateScheduleInterview($jobApplication, $interviewSchedule,$meetings));

        return Reply::redirect(route('admin.interview-schedule.index'), __('menu.interviewSchedule') . ' ' . __('messages.createdSuccessfully'));
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
    public function store(StoreJobApplication $request)
    {
        abort_if(!$this->user->cans('add_job_applications'), 403);
        $applicationStatus = ApplicationStatus::first();

        $jobApplication = new JobApplication();
        $jobApplication->full_name = $request->full_name;
        $jobApplication->job_id = $request->job_id;
        $jobApplication->status_id = $applicationStatus->id;
        $jobApplication->email = $request->email;
        $jobApplication->phone = $request->phone;
        $jobApplication->cover_letter = $request->cover_letter;
        $jobApplication->column_priority = 0;

        if ($request->has('gender')) {
            $jobApplication->gender = $request->gender;
        }
        if ($request->has('dob')) {
            $jobApplication->dob = $request->dob;
        }
        if ($request->has('country')) {
            $countriesArray = json_decode(file_get_contents(public_path('country-state-city/countries.json')), true)['countries'];
            $statesArray = json_decode(file_get_contents(public_path('country-state-city/states.json')), true)['states'];

            $jobApplication->country = $this->getName($countriesArray, $request->country);
            $jobApplication->state = $this->getName($statesArray, $request->state);
            $jobApplication->city = $request->city;
        }

        if ($request->hasFile('photo')) {
            $jobApplication->photo = Files::upload($request->photo,'candidate-photos');
        }
        $jobApplication->save();

        if ($request->hasFile('resume')) {
            $hashname = Files::upload($request->resume, 'documents/'.$jobApplication->id, null, null, false);
            $jobApplication->documents()->create([
                'name' => 'Resume',
                'hashname' => $hashname
            ]);
        }

        // Job Application Answer save
        if (isset($request->answer) && !empty($request->answer)) {
                foreach ($request->answer as $key => $value) {
                    $answer = new JobApplicationAnswer();
                    $answer->job_application_id = $jobApplication->id;
                    $answer->job_id = $request->job_id;
                    $answer->question_id = $key;
                    $answer->answer = $value;
                    $answer->save();
                }
            }

        return Reply::redirect(route('admin.job-applications.index'), __('menu.jobApplications') . ' ' . __('messages.createdSuccessfully'));
    }

    public function update(UpdateJobApplication $request, $id)
    {
        abort_if(!$this->user->cans('edit_job_applications'), 403);

        $mailSetting = ApplicationSetting::select('id', 'mail_setting')->first()->mail_setting;

        $jobApplication = JobApplication::with(['documents'])->findOrFail($id);
        $jobApplication->full_name = $request->full_name;
        $jobApplication->job_id = $request->job_id;
        $jobApplication->status_id = $request->status_id;
        $jobApplication->email = $request->email;
        $jobApplication->phone = $request->phone;
        $jobApplication->cover_letter = $request->cover_letter;

        if ($request->has('gender')) {
            $jobApplication->gender = $request->gender;
        }
        if ($request->has('dob')) {
            $jobApplication->dob = $request->dob;
        }
        if ($request->has('country')) {
            $countriesArray = json_decode(file_get_contents(public_path('country-state-city/countries.json')), true)['countries'];
            $statesArray = json_decode(file_get_contents(public_path('country-state-city/states.json')), true)['states'];

            $jobApplication->country = $this->getName($countriesArray, $request->country);
            $jobApplication->state = $this->getName($statesArray, $request->state);
            $jobApplication->city = $request->city;
        }

        if ($request->hasFile('photo')) {
            $jobApplication->photo = Files::upload($request->photo,'candidate-photos');
        }

        $isStatusDirty = $jobApplication->isDirty('status_id');

        $jobApplication->save();

        if ($request->hasFile('resume')) {
            $hashname = Files::upload($request->resume, 'documents/'.$jobApplication->id, null, null, false);
            $jobApplication->documents()->updateOrCreate([
                'documentable_type' => JobApplication::class,
                'documentable_id' => $jobApplication->id,
                'name' => 'Resume'
            ],
            [
                'hashname' => $hashname
            ]);
        }

        // Job Application Answer save
        if (isset($request->answer) && count($request->answer) > 0) {
            foreach ($request->answer as $key => $value) {
                JobApplicationAnswer::updateOrCreate([
                    'job_application_id' => $jobApplication->id,
                    'job_id' => $jobApplication->job_id,
                    'question_id' => $key
                ], ['answer' => $value]);
            }
        }
        if ($mailSetting[$request->status_id]['status'] && $isStatusDirty) {
            Notification::send($jobApplication, new CandidateStatusChange($jobApplication));
        }

        return Reply::redirect(route('admin.job-applications.table'), __('menu.jobApplications') . ' ' . __('messages.updatedSuccessfully'));
    }

    public function destroy($id)
    {
        abort_if(!$this->user->cans('delete_job_applications'), 403);

        $jobApplication = JobApplication::findOrFail($id);

        if ($jobApplication->photo) {
            Storage::delete('candidate-photos/'.$jobApplication->photo);
        }

        $jobApplication->forceDelete();

        return Reply::success(__('messages.recordDeleted'));
    }

    public function show($id)
    {
        $this->application = JobApplication::with(['schedule', 'status', 'schedule.employee', 'schedule.comments.user'])->find($id);
        $this->timezone = Company::select('id', 'timezone')->first()->timezone;
        
        $this->skills = Skill::select('id', 'name')->get();

        $this->answers = JobApplicationAnswer::with(['question'])
            ->where('job_id', $this->application->job_id)
            ->where('job_application_id', $this->application->id)
            ->get();


        $view = view('admin.job-applications.show', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    public function updateIndex(Request $request)
    {
        $taskIds = $request->applicationIds;
        $boardColumnIds = $request->boardColumnIds;
        $priorities = $request->prioritys;
        $mailSetting = ApplicationSetting::select('id', 'mail_setting')->first()->mail_setting;

        $date = Carbon::now(company()->timezone);
        $startDate = $request->startDate ?: $date->subDays(30)->format('Y-m-d');
        $endDate = $request->endDate ?: $date->format('Y-m-d');
        
        if ($request->has('applicationIds')) {
            foreach ($taskIds as $key => $taskId) {
                if (!is_null($taskId)) {

                    $task = JobApplication::find($taskId);
                    $task->column_priority = $priorities[$key];
                    $task->status_id = $boardColumnIds[$key];

                    $task->save();
                }
            }

            // Send notification to candidate on update status
            if(isset($mailSetting[$boardColumnIds[0]]['status'])){
                if($mailSetting[$boardColumnIds[0]]['status'] && $request->draggedTaskId != 0){
                    $jobApplication = JobApplication::findOrFail($request->draggedTaskId);

                    Notification::send($jobApplication, new CandidateStatusChange($jobApplication));
                }
            }

        }

        $columnCountByIds = ApplicationStatus::select('id', 'color')
            ->withCount([
                'applications as status_count' => function ($query) use($startDate, $endDate, $request) {
                    $query->withoutTrashed()->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
                    if ($request->jobs != 'all' && $request->jobs != '') {
                        $query->where('job_id', $request->jobs);
                    }
                    if ($request->search != '') {
                        $query->where('full_name', 'LIKE', '%' . $request->search . '%');
                    }
                }
            ])
            ->get()
            ->toArray();

        return Reply::dataOnly(['status' => 'success','columnCountByIds' => $columnCountByIds]);
    }

    public function table()
    {
        abort_if(!$this->user->cans('view_job_applications'), 403);

        $this->boardColumns = ApplicationStatus::all();
        $this->locations = JobLocation::all();
        $this->jobs = Job::all();
        $this->skills = Skill::all();
        return view('admin.job-applications.index', $this->data);
    }

    public function ratingSave(Request $request, $id)
    {
        abort_if(!$this->user->cans('edit_job_applications'), 403);

        $application = JobApplication::withTrashed()->findOrFail($id);
        $application->rating = $request->rating;
        $application->save();

        return Reply::success(__('messages.updatedSuccessfully'));
    }

    // Job Applications data Export
    public function export($status, $location, $startDate, $endDate, $jobs)
    {
        $filters = [
            'status' => $status,
            'location' => $location,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'jobs' => $jobs,
        ];

        $data = [
            'company' => $this->companyName
        ];

        return Excel::download(new JobApplicationExport($filters, $data), 'job-applications.xlsx', ExcelExcel::XLSX);
    }


    public function viewDetails(Request $request) {
        $candidateCount = JobApplication::count();
        if($candidateCount > 0 && !is_null($this->activePackage->package->no_of_candidate_access) && $this->activePackage->package->no_of_candidate_access <= $candidateCount) {
            $this->message = __('modules.subscription.candidatePurchase');
            return Reply::error(__('modules.subscription.candidatePurchase'));
        }

        $application = JobApplication::withTrashed()->findOrFail($request->id);
        $application->is_viewed = 1;
        $application->save();

        return Reply::dataOnly([
            'status' => 'success',
            'email' => $application->email,
            'phone' => $application->phone,
            'gender' => ucfirst($application->gender),
            'dob' => $application->dob ? $application->dob->format('jS F, Y') : '',
            'country' => $application->country,
            'state' => $application->state,
            'city' => $application->city,
            'resume' => $application->resume_url ?: ''
        ]);
    }

    public function getName($arr, $id)
    {
        $result = array_filter($arr, function ($value) use ($id) {
            return $value['id'] == $id;
        });
        return current($result)['name'];
    }

    public function archiveJobApplication(Request $request, JobApplication $application)
    {
        abort_if(!$this->user->cans('delete_job_applications'), 403);

        $application->delete();

        return Reply::success(__('messages.applicationArchivedSuccessfully'));
    }

    public function unarchiveJobApplication(Request $request, $application_id)
    {
        abort_if(!$this->user->cans('delete_job_applications'), 403);

        $application = JobApplication::select('id', 'deleted_at')->withTrashed()->where('id', $application_id)->first();
        
        $application->restore();

        return Reply::success(__('messages.applicationUnarchivedSuccessfully'));
    }

    public function addSkills(Request $request, $applicationId)
    {
        abort_if(!$this->user->cans('edit_job_applications'), 403);

        $application = JobApplication::withTrashed()->findOrFail($applicationId);

        $application->skills = $request->skills;
        $application->save();

        return Reply::success(__('messages.skillsSavedSuccessfully'));
    }
    public function getJob($jobCompanyId){
        $this->jobCompany = Job::where('job_company_id', $jobCompanyId)->where('company_id',company()->id)->get();

           return Reply::dataOnly(['jobCompany' => $this->jobCompany]);

    }
}
