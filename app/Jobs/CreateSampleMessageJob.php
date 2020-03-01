<?php

namespace App\Jobs;

use App\Models\Alias;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Support\Enums\MessageActionType;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Alias\SampleMessageNotification;

class CreateSampleMessageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** @var Alias $alias */
    private Alias $alias;

    /**
     * CreateSampleMessageJob constructor.
     * @param Alias $alias
     */
    public function __construct(Alias $alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return void
     */
    public function handle() : void
    {
        switch ($this->alias->message_action) {
            case MessageActionType::SAVE:
                $this->saveMessage();
                break;

            case MessageActionType::FORWARD_AND_SAVE:
                $this->saveMessage();
                $this->sendMessage();
                break;
        }
    }

    /**
     * @return void
     */
    private function saveMessage() : void
    {
        $this->alias
            ->messages()
            ->create([
                'subject' => 'Nice! Your alias is set up!',
                'from' => 'System',
                'sender' => 'system@relaymail.app',
                'body_html' => '<p>Great! Looks like you\'ve set up your alias!</p>',
                'body_plain' => 'Great! Looks like you\'ve set up your alias!',
                'attachment_count' => 0,
                'raw_payload' => [],
                'token' => null,
                'signature' => null,
                'properties' => [],
            ])
        ;
    }

    /**
     * @return void
     */
    private function sendMessage() : void
    {
        Notification::route('mail', $this->alias->message_forward_to)
            ->notifyNow(new SampleMessageNotification($this->alias))
        ;
    }
}
