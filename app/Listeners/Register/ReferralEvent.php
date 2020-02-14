<?php

namespace App\Listeners\Register;

use App\Models\User;
use App\Events\RegisterEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReferralEvent
{
    /**
     * @param RegisterEvent $event
     * @return void
     */
    public function handle(RegisterEvent $event) : void
    {
        $user    = $event->user;
        $request = $event->request;

        if (! $request->has('referral_code')) {
            return;
        }

        /** @var string $code */
        $code = $request->get('referral_code', '');

        /** @var User|null $referralUser */
        $referralUser = User::whereReferralCode($code)->first();

        if ($referralUser === null) {
            return;
        }

        $user->update([
            'referred_by_user_id' => $referralUser->id,
        ]);
    }
}
