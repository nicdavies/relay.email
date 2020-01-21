<?php

namespace App\Notifications\Message;

use App\Models\Message;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class NewMessageNotification extends Notification
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
            '/alias/%s/message/%s',
            $this->message->alias->uuid,
            $this->message->uuid
        );
        
        return (new MailMessage)
            ->greeting("Hello {$notifiable->name}")
            ->line("You've got a new message to {$this->message->alias->alias}")
            ->action('View', url($url)) // todo - call frontend_url() for the pwa app!
        ;
    }
}
