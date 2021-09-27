<?php

namespace App\Http\Controllers;

use App\Traits\ZoomSettings;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helper\Reply;
use App\ZoomSetting;
use App\ZoomMeeting;
use App\Http\Controllers\Controller;
use App\Setting;
use Carbon\Carbon;

class ZoomWebhookController extends Controller
{
    use ZoomSettings;
    public function __construct() {
        parent::__construct();
        
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $response = request()->all();
    //    \Log::debug([$response]);
        $this->setZoomConfigs();
        $event = $response['event'];

        switch ($event) {
            case 'meeting.started':
                $this->meetingStarted($response);
                break;
            
            case 'meeting.ended':
                $this->meetingEnded($response);
                break;

            case 'meeting.deleted':
                $this->meetingDeleted($response);
                break;

            case 'meeting.created':
                $this->meetingCreated($response);
                break;

            case 'meeting.updated':
                $this->meetingUpdated($response);
                break;
            default:
                //
                break;
        }
        return response('Webhook Handled', 200);
    }

    protected function meetingStarted($response)
    {
        $zoomMeetingId = $response['payload']['object']['id'];
        $startTime = Carbon::parse($response['payload']['object']['start_time'])->toDateString();

        $meetings = ZoomMeeting::where('meeting_id', $zoomMeetingId)->count();
        if ($meetings > 1) {
            $meeting = ZoomMeeting::where('meeting_id', $zoomMeetingId)
            ->whereDate('start_date_time', $startTime)
            ->first();
            if ($meeting) {
                $meeting->status = 'live';
                $meeting->save();
            }
        } else {
            $meeting = ZoomMeeting::where('meeting_id', $zoomMeetingId)->first();
            if ($meeting) {
                $meeting->status = 'live';
                $meeting->save();
            }    
        }
    }

    protected function meetingEnded($response)
    {
        $zoomMeetingId = $response['payload']['object']['id'];
        $startTime = Carbon::parse($response['payload']['object']['start_time'])->toDateString();
        
        $meetings = ZoomMeeting::where('meeting_id', $zoomMeetingId)->count();
        if ($meetings > 1) {
            $meeting = ZoomMeeting::where('meeting_id', $zoomMeetingId)
            ->whereDate('start_date_time', $startTime)
            ->first();
            if ($meeting) {
                $meeting->status = 'finished';
                $meeting->save();
            }
        } else {
            $meeting = ZoomMeeting::where('meeting_id', $zoomMeetingId)->first();
            if ($meeting) {
                $meeting->status = 'finished';
                $meeting->save();
            }    
        }
    }

    protected function meetingDeleted($response)
    {
        $zoomMeetingId = $response['payload']['object']['id'];

        //delete only occurrence if repeated meeting
        $meetings = ZoomMeeting::where('meeting_id', $zoomMeetingId)->orderBy('id', 'asc')->get();
        if (!is_null($meetings) && $meetings->count() > 1) {
            if (
                isset($response['payload']['operation']) 
                && $response['payload']['operation'] == 'all'
            ) {
                ZoomMeeting::where('meeting_id', $zoomMeetingId)->delete();
            } else {
                $occurrences = $response['payload']['object']['occurrences'];
                foreach ($meetings as $key => $value) {
                    $occurrenceId = $occurrences[$key]['occurrence_id'];
                    ZoomMeeting::where('occurrence_id', $occurrenceId)->delete();                
                }    
            }
        } else {
            ZoomMeeting::where('meeting_id', $zoomMeetingId)->delete();
        }
    }

    protected function meetingCreated($response)
    {
        $zoomMeetingId = $response['payload']['object']['id'];
        $meetings = ZoomMeeting::where('meeting_id', $zoomMeetingId)->orderBy('id', 'asc')->get();
        if (!is_null($meetings) && $meetings->count() > 1) {
            $occurrences = $response['payload']['object']['occurrences'];
            foreach ($meetings as $key => $value) {
                $value->occurrence_id = $occurrences[$key]['occurrence_id'];
                $value->save();
            }
        }
    }


    protected function meetingUpdated($response)
    {
        $zoomMeetingId = $response['payload']['object']['id'];
        $setting = Setting::first();

        $meetings = ZoomMeeting::where('meeting_id', $zoomMeetingId)->orderBy('id', 'asc')->get();
        if (!is_null($meetings) && $meetings->count() > 1) {
            $occurrences = $response['payload']['object']['occurrences'];
            foreach ($meetings as $key => $value) {
                $occurrenceId = $occurrences[$key]['occurrence_id'];
                if (isset($occurrences[$key]['start_time'])) {
                    $startTime = Carbon::parse($occurrences[$key]['start_time'])->timezone($setting->timezone)->toDateTimeString();
                    ZoomMeeting::where('occurrence_id', $occurrenceId)->update(['start_date_time' => $startTime]);                
                }
            }
        } else {
            if (isset($response['payload']['object']['start_time'])) {
                $startTime = Carbon::parse($response['payload']['object']['start_time'])->timezone($setting->timezone)->toDateTimeString();
                ZoomMeeting::where('meeting_id', $zoomMeetingId)->update(['start_date_time' => $startTime]);
            }
        }
    }


}
