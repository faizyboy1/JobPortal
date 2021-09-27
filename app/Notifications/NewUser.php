<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class NewUser extends BaseNotification
{

    private $password;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($password)
    {
        parent::__construct();
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject(__('email.newUser.subject'))
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
            ->line(__('email.newUser.text'))
            ->line(__('app.email') . ' - ' . $notifiable->email)
            ->line(__('app.password') . ' - ' . $this->password)
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
            //
        ];
    }
}
