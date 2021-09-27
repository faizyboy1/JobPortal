<?php

namespace App\Notifications;

use App\InterviewSchedule;
use App\ZoomMeeting;
use App\SmsSetting;
use App\Traits\SmsSettings;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class EmployeeResponse extends BaseNotification
{
    use SmsSettings;

    private $schedule, $type, $userData, $smsSetting,$meetings;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(InterviewSchedule $schedule, $type, $userData, $meetings)
    {
        parent::__construct();
        $this->schedule = $schedule;
        $this->type = $type;
        $this->userData = $userData;
        $this->meetings = $meetings;
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
        $message =  (new MailMessage)
            ->subject(__('email.interviewSchedule.scheduleResponse'))
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
            ->line(ucwords($this->userData->name) . ' ' . __('email.interviewSchedule.employeeResponse', ['type' => ucfirst($this->type), 'job' => ucwords($this->schedule->jobApplication->job->title)]) . ' ' . ucwords($this->schedule->jobApplication->full_name))
            ->line(__('email.interviewOn') . ' - ' . $this->schedule->schedule_date->format('M d, Y h:i a'));
            if(isset($this->meetings->start_link)){
                $message = $message->action(__('modules.zoommeeting.joinUrl'), getDomainSpecificUrl($this->meetings->start_link));
            }
            $message = $message->line(__('email.thankyouNote'));
            return $message;
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
                ucwords($this->userData->name) . 'has ' . ucfirst($this->type) . ' ' . ucwords($this->schedule->jobApplication->full_name) . '\'s application for ' . ucwords($this->schedule->jobApplication->job->title) . ' on ' . $this->schedule->schedule_date->format('M d, Y h:i a')
            )->unicode();
    }
}
