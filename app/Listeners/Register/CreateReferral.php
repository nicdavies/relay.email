<?php

namespace App\Listeners\Register;

use App\Models\User;
use Illuminate\Http\Request;
use App\Events\RegisterEvent;

class CreateReferral
{
    /**
     * @param RegisterEvent $event
     * @return void
     */
    public function handle(RegisterEvent $event) : void
    {
        /** @var User $user */
        $user = $event->user;

        /** @var Request $request */
        $request = $event->request;

        /** @var string|null $code */
        $code = $request->get('referral_code', null);

        if (empty($code)) {
            return;
        }

        /** @var User|null $referringUser */
        $referringUser = User::where('referral_code', $code)->first();

        if (! $referringUser instanceof User) {
            return;
        }

        $user
            ->referredByUser()
            ->create([
                'user_id' => $referringUser->id,
                'referred_user_id' => $user->id,
            ])
        ;
    }
}
