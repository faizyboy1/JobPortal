<?php

namespace Modules\Zoom\Listeners;

use Illuminate\Support\Facades\Notification;
use Modules\Zoom\Events\MeetingReminderEvent;
use Modules\Zoom\Notifications\MeetingReminder;

class MeetingReminderListener
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
    public function handle(MeetingReminderEvent $event)
    {
        $users = $event->event->attendees;
        Notification::send($users, new MeetingReminder($event->event));
    }
}
