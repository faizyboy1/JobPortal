<?php

namespace App\Notifications;

use App\JobApplication;
use App\SmsSetting;
use App\Traits\SmsSettings;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class ScheduleInterviewStatus extends BaseNotification
{
    use SmsSettings;

    private $jobApplication, $smsSetting;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(JobApplication $jobApplication)
    {
        parent::__construct();
        $this->jobApplication = $jobApplication;
        $this->smsSetting = SmsSetting::first();

        $this->setSmsConfigs();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['mail', 'database'];

        if ($this->smsSetting->nexmo_status == 'active' && $notifiable->mobile_verified == 1) {
            array_push($via, 'nexmo');
        }

        return $via;
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
            ->subject(__('email.interviewScheduleStatus.subject'))
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
            ->line($this->jobApplication->full_name . ' ' . __('email.interviewScheduleStatus.text') . ' - ' . ucwords($this->jobApplication->job->title) . ' ' . __('email.interviewScheduleStatus.statusChangesTo') . '  ' . ucFirst($this->jobApplication->status->status))
            ->action(__('email.ScheduleStatusCandidate.forCheckDetails') . ' ' . __('email.loginDashboard'), getDomainSpecificUrl(route('login'), $notifiable->company))
            ->action(__('modules.zoommeeting.joinUrl'), getDomainSpecificUrl($this->meeting->start_link))
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
            'data' => $this->jobApplication->toArray()
        ];
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content(
                $this->jobApplication->full_name . ' ' . __('email.interviewScheduleStatus.text') . ' - ' . ucwords($this->jobApplication->job->title) . ' ' . __('email.interviewScheduleStatus.statusChangesTo') . '  ' . ucFirst($this->jobApplication->status->status)
            )->unicode();
    }
}
