<?php

namespace App\Listeners\Register;

use App\Models\User;
use App\Models\Alias;
use App\Events\RegisterEvent;
use App\Support\Enums\MessageActionType;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Alias\DefaultMessageNotification;

class CreateDefaultAlias
{
    /**
     * @param RegisterEvent $event
     * @return void
     */
    public function handle(RegisterEvent $event) : void
    {
        /** @var User $user */
        $user = $event->user;

        /** @var Alias $alias */
        $alias = $user
            ->aliases()
            ->create([
                'name' => 'hello',
                'alias' => 'hello',
                'message_action' => MessageActionType::SAVE,
                'message_limit' => 999,
                'message_forward_to' => null,
                'custom_domain_id' => null,
            ])
        ;

        Notification::send($user, new DefaultMessageNotification($alias));
    }
}
