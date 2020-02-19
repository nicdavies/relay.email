<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Billing\SubscriptionResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'notification_settings' => $this->notification_settings,
            'base_alias' => $this->base_alias,
            'referral_code' => $this->referral_code,
            'referral_link' => $this->referralLink,

            'is_onboarded' => $this->isOnboarded,
            'is_verified' => $this->isVerified,

            'custom_domain' => $this->custom_domain,
            'custom_domain_is_verified' => $this->customDomainIsVerified,

            'subscription' => new SubscriptionResource($this),

            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
