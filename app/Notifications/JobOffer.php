<?php

namespace App\Notifications;

use App\JobApplication;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class JobOffer extends BaseNotification
{

    private $jobApplication;
    /**
     * JobOffer constructor.
     * @param JobApplication $jobApplication
     */
    public function __construct(JobApplication $jobApplication)
    {
        parent::__construct();
        $this->jobApplication = $jobApplication;
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

        //        if ($this->smsSetting->nexmo_status == 'active' && $notifiable->mobile_verified == 1) {
        //            array_push($via, 'nexmo');
        //        }

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
            ->subject(__('email.jobOffer.subject'))
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
            ->line(__($this->jobApplication->full_name) . ' ' . __('email.jobOffer.text') . ' - ' . ucwords($this->jobApplication->job->title))
            ->action(__('email.viewOffer'), getDomainSpecificUrl(route('jobs.job-offer', $this->jobApplication->onboard->offer_code), $notifiable->company))
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
        //
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
                __($this->jobApplication->full_name) . ' ' . __('email.jobOffer.text') . ' - ' . ucwords($this->jobApplication->job->title)
            )->unicode();
    }
}
