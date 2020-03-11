<?php

namespace App\Http\Controllers\Api\Billing\Card;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Billing\SubscriptionResource;
use Laravel\Cashier\Exceptions\InvalidStripeCustomer;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return SubscriptionResource
     * @throws ValidationException
     * @throws InvalidStripeCustomer
     */
    public function __invoke(Request $request) : SubscriptionResource
    {
        /** @var User $user */
        $user = $request->user();

        $this->validate($request, [
            'stripe_token' => ['required', 'string'],
        ]);

        if (! $user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        // Remove the existing payment method
        if ($user->hasPaymentMethod()) {
            $user->deletePaymentMethods();
        }

        $user->addPaymentMethod($request->get('stripe_token'));
        $user->updateDefaultPaymentMethod($request->get('stripe_token'));

        return new SubscriptionResource($user);
    }
}
