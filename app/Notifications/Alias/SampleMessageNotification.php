<?php

namespace App\Notifications\Alias;

use App\Models\Alias;
use App\Support\Helpers\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SampleMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Alias $alias */
    private Alias $alias;

    /**
     * SampleMessageNotification constructor.
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
        $url = url(sprintf(
            '%s/aliases/%s',
            Str::frontendUrl(),
            $this->alias->uuid,
        ));

        return (new MailMessage)
            ->subject('Nice! Your alias is set up!')
            ->line("We're sending you this email because your \"{$this->alias->name}\" alias has been set up as a {$this->alias->message_action->description} type!")
            ->action('View Alias', $url)
        ;
    }
}
