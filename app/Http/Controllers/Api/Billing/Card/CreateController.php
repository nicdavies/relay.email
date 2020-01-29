<?php

namespace App\Http\Controllers\Api\Billing\Card;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Billing\SubscriptionResource;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return SubscriptionResource
     * @throws ValidationException
     */
    public function __invoke(Request $request) : SubscriptionResource
    {
        /** @var User $user */
        $user = $request->user();

        $this->validate($request, [
            'stripe_token' => ['required', 'string'],
        ]);

        if ($user->hasPaymentMethod()) {
            // Remove the existing payment method
            $user->deletePaymentMethods();
        }

        $user->addPaymentMethod($request->get('stripe_token'));

        return new SubscriptionResource($user);
    }
}
