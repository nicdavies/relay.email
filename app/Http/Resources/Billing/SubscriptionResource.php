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
        return [
            'has_trial' => $this->onTrial(),
            'has_subscription' => $this->subscribed(),
            'has_cancelled' => $this->subscription()->cancelled(),
            'has_payment_method' => $this->hasPaymentMethod(),
            'has_grace_period' => $this->subscription()->onGracePeriod(),
            'has_ended' => $this->subscription()->ended(),
        ];
    }
}
