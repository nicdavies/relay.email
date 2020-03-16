<?php

namespace App\Notifications\Alias;

use App\Models\Alias;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DefaultMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Alias $alias */
    private Alias $alias;

    /**
     * DefaultMessageNotification constructor.
     * @param Alias $alias
     */
    public function __construct(Alias $alias)
    {
        $this->alias = $alias;
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
        return (new MailMessage)
            ->subject('Sweet! This is your new alias!')
            ->greeting('Hi')
            ->line("Looks like you've set up a new alias, we've sent you this email to test your shiny new inbox!")
            ->line("You can now receive emails at: {$this->alias->completeAliasAddress}")
        ;
    }
}
