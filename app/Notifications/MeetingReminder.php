<?php

namespace Modules\Zoom\Notifications;

use App\Notifications\BaseNotification;
use App\Traits\SmtpSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Zoom\Entities\ZoomMeeting;

class MeetingReminder extends BaseNotification
{
    private $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ZoomMeeting $event)
    {
        parent::__construct();
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = array();
        if ($notifiable->email_notifications) {
            array_push($via, 'mail');
        }
        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('email.meetingReminder.subject') . ' - ' . config('app.name'))
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
            ->line(__('email.meetingReminder.text'))
            ->line(__('modules.zoommeeting.meetingName') . ': ' . $this->event->meeting_name)
            ->line(__('app.meetings.time') . ': ' . $this->event->start_date_time->toDayDateTimeString())
            ->action(__('email.loginDashboard'), url('/'))
            ->line(__('email.thankyouNote'));
    }
}
