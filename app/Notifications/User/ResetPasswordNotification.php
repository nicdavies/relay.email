<?php

namespace App\Notifications\User;

use App\Models\PasswordReset;
use App\Support\Helpers\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var PasswordReset $passwordReset */
    private PasswordReset $passwordReset;

    /**
     * ResetPasswordNotification constructor.
     * @param PasswordReset $passwordReset
     */
    public function __construct(PasswordReset $passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }

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
        $url = sprintf(
            '%s/auth/reset-password/%s',
            Str::frontendUrl(),
            $this->passwordReset->token,
        );

        return (new MailMessage)
            ->subject('Reset Password')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $url)
            ->line(sprintf(
                'This password reset link will expire in %s minutes',
                config('auth.passwords.'.config('auth.defaults.passwords').'.expire')
            ))
            ->line('If you did not request a password reset, no further action is required.')
        ;
    }
}
