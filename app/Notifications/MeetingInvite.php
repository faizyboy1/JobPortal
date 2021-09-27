<?php

namespace App\Notifications;

use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;
use App\ZoomMeeting;

class MeetingInvite extends BaseNotification
{

    private $meeting;
    private $global;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ZoomMeeting $meeting)
    {
        parent::__construct();
        $this->meeting = $meeting;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['mail'];
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
            ->subject(__('email.newMeeting.subject') . ' - ' . config('app.name'))
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
            ->line(__('email.newMeeting.text'))
            ->line(__('modules.zoommeeting.meetingName') . ': ' . $this->meeting->meeting_name)
            ->line(__('modules.zoommeeting.startOn') . ': ' . $this->meeting->start_date_time->format('M d, Y h:i a'))
            ->line(__('modules.zoommeeting.endOn') . ': ' . $this->meeting->end_date_time->format('M d, Y h:i a'))
            ->action(__('email.loginDashboard'), url('/'))
            ->action(__('modules.zoommeeting.joinUrl'), getDomainSpecificUrl($this->meeting->start_link))
            ->line(__('email.thankyouNote'));
            
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->meeting->id,
            'start_date_time' => $this->meeting->start_date_time->format('Y-m-d H:i:s'),
            'meeting_name' => $this->meeting->meeting_name
        ];
    }
}
