<?php
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\ZoomMeeting;

class MeetingInviteEvent
{
    use Dispatchable, InteractsWithSockets ,SerializesModels;

    public $meeting;
    public $notifyUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ZoomMeeting $meeting, $notifyUser)
    {
        $this->meeting = $meeting;
        $this->notifyUser = $notifyUser;
    }
}
