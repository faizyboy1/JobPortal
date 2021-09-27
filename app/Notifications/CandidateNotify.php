<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class CandidateNotify extends BaseNotification
{

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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
            ->subject(__('email.interviewSchedule.hiredNotify'))
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->full_name) . '!')
            ->line(__('email.interviewSchedule.hiredText') . ' - ' . ucwords($notifiable->job->title))
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
