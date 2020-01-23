<?php

namespace App\Http\Controllers\Web\Billing\Subscription;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Cashier\Exceptions\PaymentFailure;
use Laravel\Cashier\Exceptions\PaymentActionRequired;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws PaymentActionRequired
     * @throws PaymentFailure
     */
    public function __invoke(Request $request) : RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->subscribed() && $user->subscription()->active()) {
            return response()
                ->redirectToRoute('billing')
                ->with('error', 'You already have an active subscription!');
        }

        // If user has cancelled their subscription and are still on their grace period, just resume the subscription
        if ($user->subscription('default')->onGracePeriod()) {
            $user
                ->subscription('default')
                ->resume()
            ;
        } else {
            $user
                ->newSubscription('default', 'premium')
                ->create()
            ;
        }

        return response()
            ->redirectToRoute('billing')
            ->with('state', 'Subscription started!')
        ;
    }
}
