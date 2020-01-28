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
            'plan' => $this->stripe_plan,
            'status' => $this->stripe_status,
            'quantity' => $this->quantity,
            'ends_at' => ($this->ends_at !== null ? $this->ends_at->toIso8601String() : null),
            'trial_ends_at' => ($this->trial_ends_at !== null ? $this->trial_ends_at->toIso8601String() : null),

            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
