<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Notification;
use App\Events\MeetingInviteEvent;
use App\Notifications\MeetingInvite;

class MeetingInviteListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MeetingInviteEvent $meeting)
    {
        Notification::send($meeting->notifyUser, new MeetingInvite($meeting->meeting));
    }
}
