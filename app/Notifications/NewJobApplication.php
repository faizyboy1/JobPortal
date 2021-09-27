<?php

namespace App\Notifications;

use App\JobApplication;
use App\SmsSetting;
use App\Traits\SmsSettings;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class NewJobApplication extends BaseNotification
{
    use  SmsSettings;
    private $jobApplication, $smsSetting, $linkedin;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(JobApplication $jobApplication, $linkedin)
    {
        parent::__construct();

        $this->jobApplication = $jobApplication;
        $this->smsSetting = SmsSetting::first();
        $this->linkedin = $linkedin;
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
        $content = __($this->jobApplication->full_name) . ' (' . $this->jobApplication->email . ') ' . __('email.newJobApplication.text') . ' - ' . ucwords($this->jobApplication->job->title);

        return (new MailMessage)
            ->subject(__('email.newJobApplication.subject'))
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
            ->markdown(
                'email.job-apply',
                [
                    'url' => getDomainSpecificUrl(route('login'), $notifiable->company), 'buttonText' => __('email.loginDashboard'),
                    'content' => $content, 'job_application' => $this->jobApplication
                ]
            );
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
                __($this->jobApplication->full_name) . ' ' . __('email.newJobApplication.text') . ' - ' . ucwords($this->jobApplication->job->title)
            )->unicode();
    }
}
