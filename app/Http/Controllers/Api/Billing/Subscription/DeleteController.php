<?php

namespace App\Http\Controllers\Api\Billing\Subscription;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Billing\SubscriptionResource;

class DeleteController extends Controller
{
    /**
     * @param Request $request
     * @return SubscriptionResource
     */
    public function __invoke(Request $request) : SubscriptionResource
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->subscribed()) {
            return new SubscriptionResource($user);
        }

        $user
            ->subscription()
            ->cancel()
        ;

        return new SubscriptionResource($user);
    }
}
