<?php

namespace App\Http\Resources\Billing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request) : array
    {
        $hasSubscription = $this->subscribed();

        return [
            'has_trial' => $this->onTrial(),
            'has_subscription' => $hasSubscription,
            'has_cancelled' => $hasSubscription ? $this->subscription()->cancelled() : false,
            'has_payment_method' => $this->hasPaymentMethod(),
            'has_grace_period' => $hasSubscription ? $this->subscription()->onGracePeriod() : false,
            'has_ended' => $hasSubscription ? $this->subscription()->ended() : false,

            'card' => [
                'brand' => $this->card_brand,
                'last_four' => $this->card_last_four
            ],
        ];
    }
}
