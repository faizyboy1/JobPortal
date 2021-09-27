<?php

namespace App\Notifications;

use App\InterviewSchedule;
use Illuminate\Notifications\Messages\MailMessage;

class CandidateReminder extends BaseNotification
{
    private $schedule;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(InterviewSchedule $schedule)
    {
        parent::__construct();
        $this->schedule = $schedule;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('email.interviewSchedule.interviewReminder'))
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->full_name) . '!')
            ->line(__('email.your') . ' ' . __('email.interviewSchedule.text') . ' - ' . ucwords($notifiable->job->title))
            ->line(__('email.on') . ' - ' . $this->schedule->schedule_date->format('M d, Y h:i a'))
            ->line(__('email.thankyouNote'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data' => $notifiable->toArray()
        ];
    }
}
