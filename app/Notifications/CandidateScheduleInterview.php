<?php

namespace App\Notifications;

use App\InterviewSchedule;
use App\JobApplication;
use App\ZoomMeeting;
use Illuminate\Notifications\Messages\MailMessage;

class CandidateScheduleInterview extends BaseNotification
{

    private $jobApplication, $interviewSchedule,$meetings;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(JobApplication $jobApplication, InterviewSchedule $interviewSchedule,$meetings)
    {
        parent::__construct();
        $this->jobApplication = $jobApplication;
        $this->interviewSchedule = $interviewSchedule;
        $this->meetings = $meetings;

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
            
        $emailContent = (new MailMessage)
            ->subject(__('email.interviewSchedule.subject'))
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->full_name) . '!')
            ->line(__('email.your') . ' ' . __('email.interviewSchedule.text') . ' - ' . ucwords($this->jobApplication->job->title))
            ->line(__('email.on') . ' - ' . $this->interviewSchedule->schedule_date->format('M d, Y h:i a'));
            if($this->meetings != null){
                $emailContent = $emailContent->line(__('modules.zoommeeting.meetingPassword') . ' - ' . ucwords($this->meetings->password));
                $emailContent = $emailContent->action(__('modules.zoommeeting.joinUrl'), getDomainSpecificUrl($this->meetings->join_link));

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
}
