<?php

namespace App\Notifications\User;

use App\Support\Helpers\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param $notifiable
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
        $token = encrypt(sprintf(
            '%s.%s',
            $notifiable->uuid,
            $notifiable->email,
        ));

        $url = sprintf(
            '%s/confirm/%s',
            Str::frontendUrl(),
            $token,
        );

        return (new MailMessage)
            ->subject('Verify Email Address')
            ->line('Please click the button below to verify your email address.')
            ->action('Verify Email Address', $url)
            ->line('If you did not create an account, no further action is required.')
        ;
    }
}
