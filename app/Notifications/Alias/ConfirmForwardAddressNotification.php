<?php

namespace App\Notifications\Alias;

use App\Models\Alias;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ConfirmForwardAddressNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Alias $alias */
    private Alias $alias;

    /**
     * ConfirmForwardAddressNotification constructor.
     * @param Alias $alias
     */
    public function __construct(Alias $alias)
    {
        $this->alias = $alias;
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
     * @return MailMessage
     */
    public function toMail($notifiable) : MailMessage
    {
        $url = route(
            'alias.update.forward.confirm',
            [
                'alias' => $this->alias,
                'token' => $this->alias->forward_to_confirmation_token,
            ],
        );

        return (new MailMessage)
            ->subject('Confirm Your Forwarding Address')
            ->greeting("Hi")
            ->line("The forwarding address for the {$this->alias->name} alias has been changed to: {$this->alias->message_forward_to}.")
            ->line('We just need you to verify to complete the setup!')
            ->action('Verify', $url)
        ;
    }
}
