<?php

declare(strict_types=1);

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) : array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable) : MailMessage
    {
        return (new MailMessage)
            ->subject('Your password has been changed!')
            ->greeting("Hi {$notifiable->name}")
            ->line('Your password has been changed from your account settings.')
            ->line('If you didn\'t perform this action, please get in touch.')
            ->action('Manage Account', url(route('account')))
        ;
    }
}
