<?php

namespace App\Notifications\Alias;

use App\Models\User;
use App\Support\Helpers\Str;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WeeklyAliasUpdateNotification extends Notification
{
    use Queueable;

    /** @var User $user */
    private User $user;

    /**
     * WeeklyAliasUpdateNotification constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        $lastWeek = Carbon::now()->subWeek();
        $today = Carbon::now();

        // Get number of new messages since last week
        $messagesSinceLastWeek = $this
            ->user
            ->messages()
            ->withoutHidden()
            ->whereDate('alias_messages.created_at', '>=', $lastWeek)
            ->whereDate('alias_messages.created_at', '<', $today)
            ->count()
        ;

        // Get number of aliases created since last week
        $aliasesSinceLastWeek = $this
            ->user
            ->aliases()
            ->whereDate('created_at', '>=', $lastWeek)
            ->whereDate('created_at', '<', $today)
            ->count()
        ;

        $url = sprintf(
            '%s/%s',
            Str::frontendUrl(),
            'home',
        );

        return (new MailMessage)
            ->subject('Your Weekly Update!')
            ->line('Here\'s your weekly update reminder:')
            ->line("You've had {$messagesSinceLastWeek} new messages in the past week.")
            ->line("You've created {$aliasesSinceLastWeek} new aliases in the past week.")
            ->action('View My Dashboard', $url)
        ;
    }
}
