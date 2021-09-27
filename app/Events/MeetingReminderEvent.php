<?php

namespace Modules\Zoom\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Zoom\Entities\ZoomMeeting;

class MeetingReminderEvent
{
    use SerializesModels;

    public $event;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ZoomMeeting $event)
    {
        $this->event = $event;
    }
}
