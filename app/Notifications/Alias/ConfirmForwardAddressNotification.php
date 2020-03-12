<?php

namespace App\Notifications\Alias;

use App\Models\Alias;
use App\Support\Helpers\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ConfirmForwardAddressNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Alias $alias */
    private Alias $alias;

    /** @var string $type - created|updated */
    private string $type;

    /**
     * ConfirmForwardAddressNotification constructor.
     * @param Alias $alias
     * @param string $type
     */
    public function __construct(Alias $alias, string $type = 'created')
    {
        $this->alias = $alias;
        $this->type = $type;
    }

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
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable) : MailMessage
    {
        $url = sprintf(
            '%s/%s/%s/%s/%s',
            Str::frontendUrl(),
            'aliases',
            $this->alias->uuid,
            'confirm',
            $this->alias->forward_to_confirmation_token,
        );

        if ($this->type === 'created') {
            $messageLine = "Your newly created alias \"{$this->alias->name}\" has set the forwarding address to: {$this->alias->message_forward_to}";
        } else {
            $messageLine = "The forwarding address for the \"{$this->alias->name}\" alias has been changed to: {$this->alias->message_forward_to}.";
        }

        return (new MailMessage)
            ->subject('Confirm Your Forwarding Address')
            ->greeting("Hello")
            ->line($messageLine)
            ->line('We just need you to verify to complete the setup!')
            ->action('Verify Alias', $url)
        ;
    }
}
