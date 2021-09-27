<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Traits\SmtpSettings;
use App\JobApplication;
use Illuminate\Support\Facades\Config;

class ReceivedApplication extends Mailable
{
    use Queueable, SerializesModels, SmtpSettings;

    public $jobApplication;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(JobApplication $jobApplication)
    {
        $this->jobApplication = $jobApplication;
        $this->setMailConfigs();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('email.applicationReceived.subject'))
            ->from(Config::get('mail.from.address'), $this->jobApplication->full_name)
            ->to($this->jobApplication->email)
            ->markdown('email.received_application');
    }
}
