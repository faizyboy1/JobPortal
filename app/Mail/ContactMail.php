<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Traits\SmtpSettings;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels, SmtpSettings;

    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->email = $request;
        $this->setMailConfigs();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('email.contact.subject'))
            ->from($this->email->email, $this->email->name)
            ->to(Config::get('mail.from.address'))
            ->markdown('email.contactmail');
    }
}
