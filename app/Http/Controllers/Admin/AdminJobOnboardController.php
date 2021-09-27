<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Designation;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\Onboard\StoreRequest;
use App\JobApplication;
use App\Notifications\JobOffer;
use App\Onboard;
use App\OnboardFiles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;


class AdminJobOnboardController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.jobOnboard';
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

        return view('admin.job-onboard.index', $this->data);
    }

    public function create(Request $request)
    {
        abort_if(!$this->user->cans('add_job_applications'), 403);

        $this->application = JobApplication::with(['job','status','job.location'])->findOrFail($request->id);

        // Abort if requested application status is not hired.
        abort_if($this->application->status->slug != 'hired', 403);

        $this->users        = User::select('id', 'company_id', 'name')->company()->get();
        $this->departments  = Department::all();
        $this->designations = Designation::all();

        return view('admin.job-onboard.create', $this->data);
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        // Save On Board Details
        $onBoard = new Onboard();
        $onBoard->job_application_id = $request->candidate_id;
        $onBoard->department_id      = $request->department;
        $onBoard->designation_id     = $request->designation;
        $onBoard->salary_offered     = $request->salary;
        $onBoard->joining_date       = $request->join_date;
        $onBoard->reports_to_id      = $request->report_to;
        $onBoard->employee_status    = $request->employee_status;
        $onBoard->accept_last_date   = $request->last_date;
        $onBoard->offer_code         = Str::random(18);
        $onBoard->save();

        $names = $request->name;
        $files = $request->file;

        if($request->has('file')){
            foreach ($names as $key => $name) :
                // Files store in directory
                $fileName = Files::upload($files[$key], 'onboard-files', null, null, false);

                // Files save
                OnboardFiles::create(
                    [
                        'on_board_detail_id' => $onBoard->id,
                        'name'               => $name,
                        'file'               => $files[$key]->getClientOriginalName(),
                        'hash_name'          => $fileName
                    ]
                );
            endforeach;
        }


        // Send Offer email
        if($request->has('send_email')){
            $this->sendOffer($request->candidate_id);
        }

        return Reply::redirect(route('admin.job-onboard.index'), __('app.onBoard') . ' ' . __('messages.createdSuccessfully'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        abort_if(!$this->user->cans('add_job_applications'), 403);

        // images format with icon
        $this->imageExt = [
            'png' => 'fa-file-image-o',  'jpe' => 'fa-file-image-o', 'jpeg' => 'fa-file-image-o', 'jpg' => 'fa-file-image-o',
            'gif' => 'fa-file-image-o',  'bmp' => 'fa-file-image-o', 'ico' => 'fa-file-image-o', 'tiff' => 'fa-file-image-o',
            'tif' => 'fa-file-image-o', 'svg' => 'fa-file-image-o', 'svgz' => 'fa-file-image-o',
        ];

        // adobe and ms office files format with icon
        $this->fileExt = [
            // adobe
            'pdf' => 'fa-file-pdf-o', 'psd' => 'fa-file-image-o', 'ai' => 'fa-file-o', 'eps' => 'fa-file-o',
            'ps' => 'fa-file-o',
            // ms office
            'doc' => 'fa-file-text', 'rtf' => 'fa-file-text', 'xls' => 'fa-file-excel-o', 'ppt' => 'fa-file-powerpoint-o',
            'docx' => 'fa-file-text', 'xlsx' => 'fa-file-excel-o', 'pptx' => 'fa-file-powerpoint-o',
            // open office
            'odt' => 'fa-file-text', 'ods' => 'fa-file-text',
        ];

        $this->onboard      = Onboard::with(['reportto', 'files'])->findOrFail($id);
        $this->application  = JobApplication::with(['job','status','job.location'])->findOrFail($this->onboard->job_application_id);
        $this->users        = User::select('id', 'company_id', 'name')->company()->get();
        $this->departments  = Department::all();
        $this->designations = Designation::all();

        return view('admin.job-onboard.edit', $this->data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function data(Request $request)
    {
        abort_if(!$this->user->cans('view_job_applications'), 403);

        $jobApplications = Onboard::select('on_board_details.id','job_applications.id as application_id', 'job_applications.full_name', 'jobs.title', 'job_locations.location','on_board_details.joining_date','on_board_details.accept_last_date', 'on_board_details.hired_status')
            ->join('job_applications', 'job_applications.id', 'on_board_details.job_application_id')
            ->leftJoin('jobs', 'jobs.id', 'job_applications.job_id')
            ->leftjoin('job_locations', 'job_locations.id', 'jobs.location_id')
            ->leftjoin('application_status', 'application_status.id', 'job_applications.status_id');

        return DataTables::of($jobApplications)
            ->addColumn('action', function ($row) {
                $action = '<div class="btn-group m-r-10 dropdown">
                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-sm btn-info dropdown-toggle" id="dropdownMenuButton" type="button">'.__('app.action').' <span class="caret"></span></button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';

                $action .= '<a href="' . route('admin.job-onboard.show', [$row->id]) . '" class="dropdown-item"><i class="fa fa-search" aria-hidden="true"></i>  '.__('app.view').'  '.__('app.offer').'</a>';
                $action .= '<a href="' . route('admin.job-onboard.edit', [$row->id]) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i> '.__('app.edit').'</a>';
                $action .= '<a href="javascript:;" data-row-id="' . $row->application_id . '" class="dropdown-item send-offer "><i class="fa fa-mail-forward" aria-hidden="true"></i> ' . __('app.send') . ' ' . __('app.offer') . '</a>';
                if($row->hired_status != 'canceled'){
                    $action .= '<a href="javascript:;" data-row-id="' . $row->id . '" class="dropdown-item sa-params"><i class="fa fa-times" aria-hidden="true"></i> '.__('app.cancel').'</a>';
                }
                $action .= '</div> </div>';

                return $action;
            })
            ->editColumn('full_name', function ($row) {
                return '<a href="javascript:;" class="show-detail" data-widget="control-sidebar" data-slide="true" data-row-id="' .  $row->application_id . '">' . ucwords($row->full_name) . '</a>';
            })
            ->editColumn('title', function ($row) {
                return ucfirst($row->title);
            })
            ->editColumn('location', function ($row) {
                return ucwords($row->location);
            })
            ->editColumn('joining_date', function ($row) {
                return (!is_null($row->joining_date)) ? $row->joining_date->format('d M Y') : '-';

            })
            ->editColumn('accept_last_date', function ($row) {
                return (!is_null($row->accept_last_date)) ? $row->accept_last_date->format('d M Y') : '-';
            })
            ->editColumn('hired_status', function ($row) {

                if($row->hired_status == 'accepted'){
                    return '<label class="badge bg-success">'.__('app.accepted').'</label>';
                }
                else if($row->hired_status == 'offered'){
                    return '<label class="badge bg-warning">'.__('app.offered').'</label>';
                }else if($row->hired_status == 'canceled'){
                    return '<label class="badge bg-danger">'.__('app.canceled').'</label>';
                }
                else{
                    return '<label class="badge bg-danger">'.__('app.rejected').'</label>';
                }
            })
            ->rawColumns(['action', 'full_name', 'hired_status'])
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * @param StoreRequest $request
     * @param $id
     * @return array
     */
    public function update(StoreRequest $request, $id)
    {
        // update On Board Details
        $onBoard = Onboard::findOrFail($id);
        $onBoard->job_application_id = $request->candidate_id;
        $onBoard->department_id      = $request->department;
        $onBoard->designation_id     = $request->designation;
        $onBoard->salary_offered     = $request->salary;
        $onBoard->joining_date       = $request->join_date;
        $onBoard->reports_to_id      = $request->report_to;
        $onBoard->employee_status    = $request->employee_status;
        $onBoard->accept_last_date   = $request->last_date;
        $onBoard->hired_status       = $request->status;

        if($onBoard->hired_status == 'rejected' || $onBoard->hired_status == 'canceled'){
            $onBoard->hired_status       = $request->reason;
        }
        $onBoard->save();

        $names = $request->name;
        $files = $request->file;
        if($request->has('file')) {
            foreach ($names as $key => $name) :
                // Files store in directory
                $fileName = Files::upload($files[$key], 'onboard-files', null, null, false);

                // Files save
                OnboardFiles::create(
                    [
                        'on_board_detail_id' => $onBoard->id,
                        'name' => $name,
                        'file' => $files[$key]->getClientOriginalName(),
                        'hash_name' => $fileName
                    ]
                );
            endforeach;
        }

        return Reply::redirect(route('admin.job-onboard.index'), __('app.onBoard') . ' ' . __('messages.updatedSuccessfully'));

    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $onBoardFiles = OnboardFiles::findOrFail($id);
        File::delete('user-uploads/onboard-files/'.$onBoardFiles->hashName);

        OnboardFiles::destroy($id);
        return Reply::success('messages.recordDeleted');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        // images format with icon
        $this->imageExt = [
            'png' => 'fa-file-image-o',  'jpe' => 'fa-file-image-o', 'jpeg' => 'fa-file-image-o', 'jpg' => 'fa-file-image-o',
            'gif' => 'fa-file-image-o',  'bmp' => 'fa-file-image-o', 'ico' => 'fa-file-image-o', 'tiff' => 'fa-file-image-o',
            'tif' => 'fa-file-image-o', 'svg' => 'fa-file-image-o', 'svgz' => 'fa-file-image-o',
        ];

        // adobe and ms office files format with icon
        $this->fileExt = [
            // adobe
            'pdf' => 'fa-file-pdf-o', 'psd' => 'fa-file-image-o', 'ai' => 'fa-file-o', 'eps' => 'fa-file-o',
            'ps' => 'fa-file-o',
            // ms office
            'doc' => 'fa-file-text', 'rtf' => 'fa-file-text', 'xls' => 'fa-file-excel-o', 'ppt' => 'fa-file-powerpoint-o',
            'docx' => 'fa-file-text', 'xlsx' => 'fa-file-excel-o', 'pptx' => 'fa-file-powerpoint-o',
            // open office
            'odt' => 'fa-file-text', 'ods' => 'fa-file-text',
        ];
        $this->onboard      = Onboard::with(['reportto', 'files'])->findOrFail($id);
        $this->application  = JobApplication::with(['job','status','job.location'])->findOrFail($this->onboard->job_application_id);
        return view('admin.job-onboard.show', $this->data);
    }


    /**
     * @param $userID
     */
    public function sendOffer($userID){
        $jobApplication = JobApplication::select('id', 'company_id', 'job_id', 'full_name', 'email')->with(['job:id,title', 'onboard:id,offer_code,job_application_id,hired_status'])->where('id', $userID)->first();

        if ($jobApplication->onboard->hired_status !== 'offered') {
            $jobApplication->onboard->hired_status = 'offered';

            $jobApplication->onboard->save();
        }
        
        // Send Email Or Sms to applicant.Request
        $jobApplication->notify(new JobOffer($jobApplication));

        return Reply::success(__('messages.offer.offerSentSuccessfully'));
    }

    /**
     * @param $id
     * @return array
     */
    public function updateStatus($id){

        $onboard = Onboard::findOrFail($id);
        $onboard->hired_status = 'canceled';
        $onboard->save();

        return Reply::success(__('messages.offer.updatedSuccessfully'));
    }

}
