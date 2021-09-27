<?php

namespace App\Notifications;

use App\JobApplication;
use App\SmsSetting;
use App\ZoomMeeting;
use App\Traits\SmsSettings;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class ScheduleInterview extends BaseNotification
{
    use SmsSettings;
    private $jobApplication, $smsSetting,$meetings;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(JobApplication $jobApplication , $meetings)
    {
        parent::__construct();
        $this->jobApplication = $jobApplication;
        $this->smsSetting = SmsSetting::first();
        $this->meetings = $meetings;
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
        $emailContent =  (new MailMessage)
            ->subject(__('email.interviewSchedule.subject'))
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
            ->line(__($this->jobApplication->full_name) . ' ' . __('email.interviewSchedule.text') . ' - ' . ucwords($this->jobApplication->job->title))
            ->action(__('email.interviewSchedule.response') . ' ' . __('email.loginDashboard'), getDomainSpecificUrl(route('login'), $notifiable->company));
            if($this->meetings != null){
                $emailContent = $emailContent->line(__('modules.zoommeeting.meetingPassword') . ' - ' . ucwords($this->meetings->password));
                if( $notifiable->id == $this->meetings->created_by ){
                $emailContent = $emailContent->action(__('modules.zoommeeting.startUrl'), getDomainSpecificUrl($this->meetings->start_link));
                }else{
                    $emailContent = $emailContent->action(__('modules.zoommeeting.joinUrl'), getDomainSpecificUrl($this->meetings->join_link));
                }

            }else{
                $emailContent =  $emailContent->line(__('modules.interviewSchedule.interviewType').' - ' . __('modules.meetings.offline'));
            }
    
            $emailContent = $emailContent->line(__('email.thankyouNote'));
            return $emailContent;
            
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
                __($this->jobApplication->full_name) . ' ' . __('email.interviewSchedule.text') . ' - ' . ucwords($this->jobApplication->job->title)
            )->unicode();
    }
}
