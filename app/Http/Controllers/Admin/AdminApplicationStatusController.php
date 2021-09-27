<?php

namespace App\Http\Controllers\Admin;

use App\ApplicationSetting;
use App\ApplicationStatus;
use App\Helper\Reply;
use App\Http\Requests\Admin\ApplicationStatus\StoreRequest;
use App\Http\Requests\Admin\ApplicationStatus\UpdateRequest;
use App\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AdminApplicationStatusController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.myProfile');
        $this->pageIcon = 'ti-user';
    }

    public function index()
    {
        //
    }

    public function create()
    {
        $statuses = ApplicationStatus::select('id', 'company_id', 'status', 'position')->orderBy('position')->get();

        return view('admin.job-applications.create-status', compact('statuses'));
    }

    public function store(StoreRequest $request)
    {
        $statuses = ApplicationStatus::select('id', 'company_id', 'position')->where('position', '>', $request->status_position)->get();

        foreach ($statuses as $status) {
            $status->position = $status->position + 1;

            $status->save();
        }

        $status = new ApplicationStatus();
        
        $status->status = $request->status;
        $status->color = $request->status_color;
        $status->position = $request->status_position + 1;
        $status->slug = $request->slug;


        $status->save();

        // update mail settings
        $applicationSetting = ApplicationSetting::select('id', 'company_id', 'mail_setting')->first();

        $arrData = $applicationSetting->mail_setting;

        $arrData[$status->id] = ['name' => $status->status, 'status' => true];

        $applicationSetting->mail_setting = $arrData;
        
        $applicationSetting->save();

        return Reply::success(__('messages.createdSuccessfully'));
    }

    public function edit($id)
    {
        $status = ApplicationStatus::select('id', 'company_id', 'status', 'color', 'position')->where('id', $id)->first();
        $allStatuses = ApplicationStatus::select('id', 'company_id', 'status', 'position')->orderBy('position')->get();
        $statuses = $allStatuses->filter(function($stat) use($status) {
            return $stat->position !== $status->position && $stat->position !== $status->position-1;
        });
        $firstStatus = $allStatuses->filter(function($stat) {
            return $stat->position === 1;
        })->first();

        return view('admin.job-applications.edit-status', compact('status', 'statuses', 'firstStatus'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $status = ApplicationStatus::select('id', 'company_id', 'status', 'color', 'position')->where('id', $id)->first();

        if ($request->status_position !== 'no_change') {
            if ($request->status_position === 'before_first') {
                $statuses = ApplicationStatus::select('id', 'company_id', 'position')->where('position', '<', $status->position)->get();
    
                foreach ($statuses as $stat) {
                    $stat->position = $stat->position + 1;
                    
                    $stat->save();
                }
                $status->position = 1;              
            }else{
                if ($status->position - $request->status_position > 1) {
                    $statuses = ApplicationStatus::select('id', 'company_id', 'position')->where('position', '>', $request->status_position)->where('position', '<=', $status->position)->get();
        
                    foreach ($statuses as $stat) {
                        $stat->position = $stat->position + 1;
                        
                        $stat->save();
                    }
                    $status->position = $request->status_position + 1;
                }
                if ($request->status_position - $status->position > 0){
                    $statuses = ApplicationStatus::select('id', 'company_id', 'position')->where('position', '<=', $request->status_position)->where('position', '>=', $status->position)->get();
                    
                    foreach ($statuses as $stat) {
                        $stat->position = $stat->position - 1;
                        
                        $stat->save();
                    }
                    $status->position = $request->status_position;
                }
            }
        }

        $status->status = $request->status;
        $status->color = $request->status_color;

        $status->save();

        return Reply::success(__('messages.updatedSuccessfully'));
    }

    public function destroy(Request $request, $id)
    {
        if ($request->has('applicationIds')) {
            foreach ($request->applicationIds as $applicationId) {
                $application = JobApplication::where('id', $applicationId)->first();

                $application->status_id = 1;

                $application->save();

                $application->delete();
            }
        }

        $status = ApplicationStatus::findOrFail($id);

        $statuses = ApplicationStatus::select('id', 'company_id', 'position')->where('position', '>', $status->position)->get();

        foreach ($statuses as $stat) {
            $stat->position = $stat->position - 1;
            
            $stat->save();
        }

        $applicationSetting = ApplicationSetting::select('id', 'company_id', 'mail_setting')->first();

        $applicationSetting->mail_setting = array_except($applicationSetting->mail_setting, $status->id);
        
        $applicationSetting->save();

        $status->delete();

        return Reply::success(__('messages.recordDeleted'));
    }
}
