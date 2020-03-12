<?php

namespace App\Notifications\Message;

use App\Models\Message;
use App\Support\Helpers\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Message $message;

    /**
     * NewMessageNotification constructor.
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable) : array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable) : MailMessage
    {
        $url = sprintf(
            '%s/aliases/%s/message/%s',
            Str::frontendUrl(),
            $this->message->alias->uuid,
            $this->message->uuid
        );

        return (new MailMessage)
            ->subject("You've received a new message through RelayMail")
            ->greeting("Hello")
            ->line("You've just receieved a new message to \"{$this->message->alias->alias}\" on RelayMail.")
            ->action('View Message', $url)
        ;
    }
}
