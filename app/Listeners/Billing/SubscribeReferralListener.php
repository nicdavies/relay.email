<?php

namespace App\Listeners\Billing;

use App\Notifications\User\ReferralSubscribedNotification;
use Carbon\Carbon;
use App\Models\User;
use App\Events\Billing\SubscribeEvent;
use Illuminate\Support\Facades\Notification;

class SubscribeReferralListener
{
    /** @var User $user */
    private $user;

    /**
     * @param SubscribeEvent $event
     */
    public function handle(SubscribeEvent $event) : void
    {
        /** @var User $user */
        $user = $event->user;
        $this->user = $user;

        // If the user wasn't referred, we don't need to do anything!
        if (! $user->was_referred) {
            return;
        }

        /** @var User $referredByUser */
        $referredByUser = $user->referredByUser();

        // If the user has an active (paying) subscription
        if ($referredByUser->subscription()->recurring()) {
            $referredByUser
                ->subscription()
                ->anchorBillingCycleOn(Carbon::now()->addMonth())
            ;

            $this->sendNotification();
            return;
        }

        // If the user has an active subscription but on trial
        if ($referredByUser->subscription()->onTrial()){
            $referredByUser->update([
                'trial_ends_at' => Carbon::now()->addMonth(),
            ]);

            $this->sendNotification();
            return;
        }

        // If the user has a cancelled but grace-period subscription
        if ($user->subscription()->onGracePeriod()) {
            $referredByUser->update([
                'trial_ends_at' => Carbon::now()->addMonth(),
            ]);

            $this->sendNotification();
            return;
        }

        // If the user had a subscription but now ended
        if ($referredByUser->subscription()->ended()) {
            $referredByUser->update([
                'trial_ends_at' => Carbon::now()->addMonth(),
            ]);

            $this->sendNotification();
            return;
        }

        // If the user has a cancelled subscription
        if ($referredByUser->subscription()->cancelled()) {
            $referredByUser->update([
                'trial_ends_at' => Carbon::now()->addMonth(),
            ]);

            $this->sendNotification();
            return;
        }

        // If the user doesn't have a subscription: bump the trial period by 1 month
        if ($referredByUser->subscription() === null) {
            $referredByUser->update([
                'trial_ends_at' => Carbon::now()->addMonth(),
            ]);

            $this->sendNotification();
        }
    }

    /**
     * @return void
     */
    private function sendNotification() : void
    {
        Notification::send($this->user, new ReferralSubscribedNotification());
    }
}
