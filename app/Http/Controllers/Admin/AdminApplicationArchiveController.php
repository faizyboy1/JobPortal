<?php

namespace App\Http\Controllers\Admin;

use App\Exports\JobApplicationArchiveExport;
use App\Helper\Reply;
use App\JobApplication;
use App\JobApplicationAnswer;
use App\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;


class AdminApplicationArchiveController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.candidateDatabase';
        $this->pageIcon = 'icon-drawer';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!$this->user->cans('view_job_applications'), 403);

        return view('admin.applications-archive.index', $this->data);
    }

    public function data(Request $request)
    {
        abort_if(!$this->user->cans('view_job_applications'), 403);

        $jobApplications = JobApplication::onlyTrashed();

        // Filter by skills
        if ($request->has('skill') && $request->skill !== null) {
            $skill = Skill::select('id', 'name')->where('name', 'LIKE', '%'.strtolower($request->skill).'%')->first();

            if ($skill) {
                $jobApplications = $jobApplications->whereJsonContains('skills', (string) $skill->id)->get();
            }
            else {
                $jobApplications = collect([]);
            }
        }
        else {
            $jobApplications = $jobApplications->get();
        }
        return DataTables::of($jobApplications)
            ->editColumn('full_name', function ($row) {
                return '<a href="javascript:;" class="show-detail" data-widget="control-sidebar" data-slide="true" data-row-id="' . $row->id . '">' . ucwords($row->full_name) . '</a>';
            })
            ->editColumn('title', function ($row) {
                return ucfirst($row->job->title);
            })
            ->editColumn('location', function ($row) {
                return ucwords($row->job->location->location);
            })
            ->rawColumns(['action', 'full_name'])
            ->addIndexColumn()
            ->make(true);
    }

    public function destroy($id)
    {
        abort_if(!$this->user->cans('delete_job_applications'), 403);

        $jobApplication = JobApplication::findOrFail($id);

        if ($jobApplication->photo) {
            Storage::delete('candidate-photos/'.$jobApplication->photo);
        }

        $jobApplication->delete();
        // JobApplication::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }

    public function show($id)
    {
        $this->application = JobApplication::with(['schedule','notes','onboard', 'status', 'schedule.employee', 'schedule.comments.user'])->withTrashed()->find($id);

        $this->skills = Skill::select('id', 'name')->get();

        $this->answers = JobApplicationAnswer::with(['question'])
            ->where('job_id', $this->application->job_id)
            ->where('job_application_id', $this->application->id)
            ->get();


        $view = view('admin.applications-archive.show', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    public function export($skill)
    {
        $filters = [
            'skill' => $skill
        ];

        $data = [
            'company' => $this->companyName
        ];

        return Excel::download(new JobApplicationArchiveExport($filters, $data), __('modules.applicationArchive.exportFileName').'.xlsx', ExcelExcel::XLSX);
    }
}
