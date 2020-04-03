<?php

namespace App\Http\Controllers\Api\Billing\Subscription;

use App\Events\Billing\SubscribeEvent;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Cashier\Exceptions\PaymentFailure;
use App\Http\Resources\Billing\SubscriptionResource;
use Laravel\Cashier\Exceptions\PaymentActionRequired;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return SubscriptionResource
     * @throws PaymentActionRequired
     * @throws PaymentFailure
     */
    public function __invoke(Request $request) : SubscriptionResource
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->subscribed() && $user->subscription()->active()) {
            return new SubscriptionResource($user);
        }

        // If user has cancelled their subscription and are still on their grace period, just resume
        if ($user->subscription() !== null && $user->subscription()->onGracePeriod()) {
            $user
                ->subscription()
                ->resume()
            ;
        } else {
            $user
                ->newSubscription('default', 'premium_monthly')
                ->create()
            ;

            event(new SubscribeEvent($user));
        }

        return new SubscriptionResource($user);
    }
}
