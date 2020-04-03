<?php

namespace App\Notifications\User;

use App\Support\Helpers\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReferralSubscribedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable) : array
    {
        return ['mail'];
    }

    /**
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable) : MailMessage
    {
        $url = sprintf(
            '%s/home',
            Str::frontendUrl()
        );

        return (new MailMessage)
            ->greeting('Hello!')
            ->line('A user you\'ve referred has just upgraded to a premium plan, so we\'ve given you a month for free!')
            ->action('Login', $url)
        ;
    }
}
