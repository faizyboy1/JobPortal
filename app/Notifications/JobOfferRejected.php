<?php

namespace App\Notifications;

use App\JobApplication;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class JobOfferRejected extends BaseNotification
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
        $via = ['mail', 'database'];

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
            ->subject(__('email.jobOfferRejected.subject'))
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
            ->line(__('email.jobOfferRejected.text') . ' by ' . __($this->jobApplication->full_name) . ' for job ' . ucwords($this->jobApplication->job->title))
            ->action(__('email.loginDashboard'), getDomainSpecificUrl(route('login'), $notifiable->company))
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
            'data' => $this->jobApplication->onboard->toArray()
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
                __('email.jobOfferRejected.text') . ' by ' . __($this->jobApplication->full_name) . ' for job' . ucwords($this->jobApplication->job->title)
            )->unicode();
    }
}
