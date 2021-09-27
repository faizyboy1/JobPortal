<?php

namespace App\Notifications;

use App\SmsSetting;
use App\Traits\SmsSettings;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class NewJobOpening extends BaseNotification
{
    use  SmsSettings;

    private $job, $smsSetting;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($job)
    {
        parent::__construct();
        $this->job = $job;
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
        $via = ['mail'];

        if ($this->smsSetting->nexmo_status == 'active') {
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
        // dd($this->jobApplication->job);
        return (new MailMessage)
            ->subject(__('email.newJobOpening.subject'))
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->full_name) . '!')
            ->line(__('email.newJobOpening.text'))
            ->line(__('email.newJobOpening.jobTitle') . ' - ' . $this->job->title)
            ->line(__('email.newJobOpening.jobLocation') . ' - ' . $this->job->location->location)
            ->line(__('email.newJobOpening.moreDetails'))
            ->action(__('email.newJobOpening.jobDetails'), getDomainSpecificUrl(route('jobs.jobDetail', [$this->job->slug]), $notifiable->company))
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
            'data' => $this->job->toArray()
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
        $link = '<a href="' . route('jobs.jobDetail', [$this->job->slug]) . '">Link</a>';

        return (new NexmoMessage)
            ->content(
                __('email.newJobOpening.text') . "\n" .
                    __('email.newJobOpening.phoneMessage') . " " . $link
            )->unicode();
    }
}
