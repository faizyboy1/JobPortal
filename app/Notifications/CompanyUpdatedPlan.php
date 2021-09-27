<?php

namespace App\Notifications;

use App\Company;
use App\Package;
use App\SmsSetting;
use App\Traits\SmsSettings;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class CompanyUpdatedPlan extends BaseNotification
{
    use SmsSettings;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $company, $package, $smsSetting;

    public function __construct(Company $company, $packageID)
    {
        parent::__construct();
        $this->company = $company;
        $this->package = Package::findOrFail($packageID);
        $this->smsSetting = SmsSetting::first();

        $this->setSmsConfigs();
    }

    /**
     * Get the notification's delivery channels.
     *t('mail::layout')
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['mail'];

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

        return (new MailMessage)
            ->subject(__('email.planUpdate.subject') . ' ' . config('app.name') . '!')
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
            ->line(__($this->company->company_name . ' ' . 'email.planUpdate.text') . ' ' . $this->package->name)
            ->action(__('email.loginDashboard'), url('/'))
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
        return array_merge($notifiable->toArray(), ['company_name' => $this->company->company_name, 'name' => $this->package->name]);
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
                __($this->company->company_name . ' ' . 'email.planUpdate.text') . ' ' . $this->package->name
            )->unicode();
    }
}
