<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Traits\ZoomSettings;
use App\User;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use MacsiDigital\Zoom\Facades\Zoom;
use App\ZoomMeeting;
use App\Events\MeetingInviteEvent;
use App\Http\Requests\ZoomMeeting\StoreMeeting;
use Yajra\DataTables\Facades\DataTables;
use App\ZoomSetting;
use App\Category;
use App\Http\Requests\ZoomMeeting\UpdateMeeting;
use App\Http\Requests\ZoomMeeting\UpdateOccurrence;
use Illuminate\Support\Facades\Config;

class AdminZoomMeetingController extends AdminBaseController
{
    use ZoomSettings;
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.zoom');
        $this->pageIcon = 'icon-film';
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $this->employees =  User::with('company')->company()->get();
        $this->events = ZoomMeeting::all();
        $this->categories = Category::all();
        return view('admin.zoom.meeting-calendar.index', $this->data);
    }
    public function data()
    {
        $model = ZoomMeeting::select('id', 'meeting_id', 'created_by', 'meeting_name', 'start_date_time', 'end_date_time', 'start_link', 'join_link', 'status', 'label_color', 'occurrence_id', 'source_meeting_id',
        'occurrence_order')->get();
        $this->zoomSetting = ZoomSetting::first();
        return DataTables::of( $model)
        ->addColumn('action',  function ($row) {
            if ($this->zoomSetting->meeting_app == 'in_app') {
                $url = route('admin.zoom-meeting.startMeeting', $row->id);
            } else {
                $url = $this->user->id == $row->created_by ? $row->start_link : $row->end_link;
            }
            
            $action = '<div class="btn-group dropdown m-r-10">
            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button">
                <i class="fa fa-gears "></i>
            </button>
            <ul role="menu" class="dropdown-menu drop-down-new">';
            if ($this->user->cans('view_schedule')) {
                $action.= '<li>
                <a href="javascript:;" onclick="getEventDetail('.$row->id.')" >
                    <i class="fa fa-eye "></i> '.__('app.view').'
                </a>
            </li>';
            }
    
            if ($row->status == 'waiting') {
                $nowDate = Carbon::now()->toDateString();
                $meetingDate = $row->start_date_time->toDateString();

                if (
                    (is_null($row->occurrence_id) || $nowDate == $meetingDate)
                    && $row->created_by == $this->user->id
                ) {
                    $action.= '<li>
                        <a target="_blank" href="' . $url . '" >
                            <i class="fa fa-play"></i> '.__('modules.zoommeeting.startUrl').'
                        </a>
                    </li>';
                }
                
                $action.= '<li>
                    <a href="javascript:;" class="cancel-meeting" data-meeting-id="'.$row->id.'" >
                        <i class="fa fa-times"></i> '.__('modules.zoommeeting.cancelMeeting').'
                    </a>
                </li>';
                if ($this->user->cans('edit_schedule')) {
                $action.= '<li>
                    <a href="javascript:;" class="btnedit" data-id="' . $row->id . '"  >
                        <i class="fa fa-pencil"></i> ' . __('app.edit') . '
                    </a>
                </li>';
                }
            }
    
            if ($row->status == 'live') {
                if ($this->user->cans('delete_schedule')) {
                $action.= '<li>
                    <a href="javascript:;" class="end-meeting" data-meeting-id="'.$row->id.'" >
                        <i class="fa fa-stop"></i> '.__('modules.zoommeeting.endMeeting').'
                    </a>
                </li>';
                }
            }

            if ($row->status != 'live') {
                $action.= '<li>
                    <a href="javascript:;" class="sa-params" data-occurrence="'.$row->occurrence_order.'" data-meeting-id="' . $row->id . '">
                        <i class="fa fa-trash"></i> ' . __('app.delete') . '
                    </a>
                </li>';
            }

            $action.= '</ul></div>';

            return $action;
        })
        ->editColumn('meeting_id', function ($row)
        {   
            $meetingId = $row->meeting_id;

            if (!is_null($row->occurrence_id)) {
                $meetingId.= '<br><span class="text-muted">' . __('modules.zoommeeting.occurrence') . ' - ' . $row->occurrence_order . '</span>';
            }
            return $meetingId;
        })
        ->editColumn('meeting_name', function ($row)
        {
            if ($this->user->cans('view_schedule')) {
            return ' <a href="javascript:;" onclick="getEventDetail('.$row->id.')">' . ucfirst($row->meeting_name).'</a>';
        }else{
            return ' <label>' . ucfirst($row->meeting_name).'</label>';
         }
        })
        ->editColumn('start_date_time', function ($row)
        {
            return $row->start_date_time;
        })
        ->editColumn('end_date_time', function ($row)
        {
            return $row->end_date_time;
        })
        ->editColumn('status', function ($row) {

            if ($row->status == 'waiting') {
                $status = '<label class="label badge label-warning">' . __('modules.zoommeeting.waiting') . '</label>';
            } else if ($row->status == 'live') {
                $status = '<i class="fa fa-circle Blink" style="color: red"></i> <span class="font-semi-bold">' . __('modules.zoommeeting.live') .'</span>';
            } else if ($row->status == 'canceled') {
                $status = '<label class="label badge label-danger">' . __('app.canceled') . '</label>';
            } else if ($row->status == 'finished') {
                $status = '<label class="label badge label-success">' . __('app.finished') . '</label>';
            }
            return $status;
        })
        ->rawColumns(['action', 'status', 'meeting_name', 'meeting_id'])
        ->addIndexColumn()
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admin.zoom-meeting.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(StoreMeeting $request)
    {
        $this->createOrUpdateMeetings($request);

        return Reply::success(__('messages.createdSuccessfully'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $event = ZoomMeeting::with('attendees', 'host')->findOrFail($id);
        $this->zoomSetting = ZoomSetting::first();
        return view('admin.zoom.meeting-calendar.show', ['event' => $event, 'global' => $this->global, 'zoomSetting' => $this->zoomSetting]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $this->setZoomConfigs();
        $this->event = ZoomMeeting::with('attendees')->findOrFail($id);
        $this->employees = User::with('company')->company()->get();
        $this->categories = Category::all();
        if (!is_null($this->event->occurrence_id)) {
            return view('admin.zoom.meeting-calendar.edit_occurrence', $this->data);
        }

        return view('admin.zoom.meeting-calendar.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateMeeting $request, $id)
    {
        $this->createOrUpdateMeetings($request, $id);

        return Reply::success(__('messages.updatedSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->setZoomConfigs();
        $meeting = ZoomMeeting::findOrFail($id);

        // destroy meeting via zoom api
        if (!is_null($meeting->occurrence_id)) {
            $zoomMeeting =  Zoom::meeting()->find($meeting->meeting_id);

            if (request()->has('recurring') && request('recurring') == "yes") {
                //delete all occurrences
                $occurrence = $zoomMeeting->occurrences()->delete();
            } else {
                //delete single occurrence
                $occurrence = $zoomMeeting->occurrences()->find($meeting->occurrence_id);
                $occurrence->delete();
            }
        } else {
            $zoomMeeting = Zoom::user()->find('me')->meetings()->find($meeting->meeting_id);
            if ($zoomMeeting) {
                $zoomMeeting->delete();
            }
        }

        $meeting->attendees()->detach();
        $meeting->delete();

        return Reply::success(__('messages.recordDeleted'));
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

    public function createOrUpdateMeetings($request, $id = null)
    {
        $this->setZoomConfigs();
        $host = User::find($request->create_by);
        $user = Zoom::user()->find('me');

        if ($request->has('repeat') && $request->repeat) {
            $this->createRepeatMeeting($user, $request, $id);
        } else {

            $meeting = is_null($id) ? new ZoomMeeting() : ZoomMeeting::find($id);
            $data = $request->all();
            $data['meeting_name'] = $request->meeting_title;
            $data['start_date_time'] = $request->start_date . ' ' . $request->start_time;
            $data['end_date_time'] = $request->end_date . ' ' . $request->end_time;
            if (is_null($id)) {
                $meeting = $meeting->create($data);
                $this->syncAttendees($request, $meeting, 'yes');
            } else {

                $meeting->update($data);

                $this->syncAttendees($request, $meeting);
            }
            $this->createMeeting($user, $meeting, $id, null, $host);
        }
    }

    public function syncAttendees($request, $meeting, $sendInvitation = null)
    {
        $this->setZoomConfigs();
        $attendees = [];
        if ($request->all_employees) {
            $attendees = User::allEmployees();
        } else {
            if($request->employee_id){
                $attendees = User::whereIn('id', $request->employee_id)->get();
                

            }
        }
        if ($request->all_clients) {
            $attendees = User::allClients()->merge($attendees);
        } elseif ($request->has('client_id')) {
            $attendees = User::whereIn('id', $request->client_id)->get()->merge($attendees);
        }
        if($attendees)
        {
            $meeting->attendees()->sync($attendees);
        }

        if ($sendInvitation === 'yes') {
            event(new MeetingInviteEvent($meeting, $attendees));
        }
    }

    public function tableView()
    {    
        $this->users = User::with('company')->company()->get();
        $this->categories = Category::all();
        return view('admin.zoom.meeting-calendar.table', $this->data);

    }

    /**
     * start zoom meeting in app
     *
     * @return \Illuminate\Http\Response
     */
    public function startMeeting($id)
    {
        $this->setZoomConfigs();
        $this->zoomSetting = ZoomSetting::first();
        $this->meeting = ZoomMeeting::findOrFail($id);
        $this->zoomMeeting = Zoom::meeting()->find($this->meeting->meeting_id);
        return view('admin.zoom.meeting-calendar.start_meeting', $this->data);
    }

    /**
     * cancel meeting
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelMeeting()
    {
        $this->setZoomConfigs();
        $id = request('id');
        ZoomMeeting::where('id', $id)->update([
            'status' => 'canceled'
        ]);

        return Reply::success(__('messages.updatedSuccessfully'));
    }

    /**
     * end meeting
     *
     * @return \Illuminate\Http\Response
     */
    public function endMeeting()
    {
        $this->setZoomConfigs();
        $id = request('id');
        $meeting = ZoomMeeting::findOrFail($id);

        $zoomMeeting = Zoom::meeting()->find($meeting->meeting_id);
        if ($zoomMeeting) {
            $zoomMeeting->endMeeting();
        }

        $meeting->status = 'finished';
        $meeting->save();

        return Reply::success(__('messages.updatedSuccessfully'));
    }

    /**
     * create repeated meeting
     *
     * @return \Illuminate\Http\Response
     */
    public function createRepeatMeeting($user, $request, $id)
    {
        $this->setZoomConfigs();
        //create first record in db
        $meeting = new ZoomMeeting();
        $data = $request->all();
        $data['meeting_name'] = $request->meeting_title;
        $data['start_date_time'] = $request->start_date . ' ' . $request->start_time;
        $data['end_date_time'] = $request->end_date . ' ' . $request->end_time;
        $meeting = $meeting->create($data);
        $meeting->source_meeting_id = $meeting->id;
        $meeting->occurrence_order = 1;
        $meeting->save();
        $meetingId = $meeting->id;

        $this->syncAttendees($request, $meeting, 'yes');

        //create other records with reference to first
        $repeatCount = $request->repeat_every;
        $repeatType = $request->repeat_type;
        $repeatCycles = $request->repeat_cycles;
        $startDate =$request->start_date;
        $dueDate =  $request->end_date;
        $startDate = Carbon::parse( $request->start_date);
        $dueDate = Carbon::parse($request->end_date);


        for ($i = 1; $i < $repeatCycles; $i++) {
            // print_r(str_plural($repeatType));
            // dd($repeatCount);
            $startDate = $startDate->add($repeatCount, str_plural($repeatType));
            $dueDate = $dueDate->add($repeatCount, str_plural($repeatType));

            $otherMeeting = new ZoomMeeting();

            $data['start_date_time'] = $startDate->format($this->global->date_format) . '' . $request->start_time;
            $data['end_date_time'] = $dueDate->format($this->global->date_format) . '' . $request->end_time;
            $data['source_meeting_id'] = $meetingId;
            $data['occurrence_order'] = $i + 1;
            $otherMeeting = $otherMeeting->create($data);
            $this->syncAttendees($request, $otherMeeting);
        }

        //create meeting on zoom
        // $startDate = Carbon::createFromFormat($this->global->date_format . ' ' . $this->global->time_format, $request->start_date . ' ' . $request->start_time);
        $startDate =($request->start_date . ' ' . $request->start_time);

        $zoomMeeting = Zoom::meeting()->make([
            'topic' => $request->meeting_title,
            'type' => 8,
            'start_time' => $startDate, // best to use a Carbon instance here.
            'agenda' => $request->description,
            'settings' => [
                'host_video' => $request->host_video == 1,
                'participant_video' => $request->participant_video == 1,
            ]
        ]);

        $repeatInterval = $request->repeat_every;
        $repeatCycles = $request->repeat_cycles;

        if ($request->repeat_type == "day") {
            $repeatType = 1;
        } elseif ($request->repeat_type == "week") {
            $repeatType = 2;
        } else {
            $repeatType = 3;
        }

        $repeatData = [
            'type' => $repeatType,
            'repeat_interval' => intval($repeatInterval),
            'end_times' => intval($repeatCycles)
        ];

        if ($repeatType == 2) {
            $repeatData['weekly_days'] = $startDate->dayOfWeek + 1;
        }

        $zoomMeeting->recurrence()->make($repeatData);
        $savedMeeting = $user->meetings()->save($zoomMeeting);


        //save zoom response data
        $meeting->meeting_id = $savedMeeting->id;
        $meeting->start_link = $savedMeeting->start_url;
        $meeting->join_link = $savedMeeting->join_url;
        $meeting->password = $savedMeeting->password;
        $meeting->save();

        $repeatCycles = $request->repeat_cycles;
        $meetingId = $meeting->id;

        for ($i = 1; $i < $repeatCycles; $i++) {
            ZoomMeeting::where('source_meeting_id', $meetingId)->update(
                [
                    'meeting_id' => $savedMeeting->id,
                    'start_link' => $savedMeeting->start_url,
                    'join_link' => $savedMeeting->join_url,
                    'password' => $savedMeeting->password,
                ]
            );
        }
    }

    /**
     * update meeting occurrence
     *
     * @return \Illuminate\Http\Response
     */
    public function updateOccurrence(UpdateOccurrence $request, $id)
    {
        $this->setZoomConfigs();
        $zoomMeeting = ZoomMeeting::find($id);
        $data = $request->all();
        $data['start_date_time'] = $request->start_date . 'T' . $request->start_time;
        $data['end_date_time'] = $request->end_date . 'T' . $request->end_time;
        $zoomMeeting->update($data);

        $meeting =  Zoom::meeting()->find($zoomMeeting->meeting_id);
        $occurrence = $meeting->occurrences()->find($zoomMeeting->occurrence_id);
        $occurrence->start_time = $zoomMeeting->start_date_time;
        $occurrence->save();
        return Reply::success(__('messages.updatedSuccessfully'));
    }
}
