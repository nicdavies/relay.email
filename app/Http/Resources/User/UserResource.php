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
            'avatar' => $this->avatar,

            'notification_settings' => $this->notification_settings,
            'base_alias' => $this->base_alias,
            'referral_code' => $this->referral_code,
            'referral_link' => $this->referralLink,

            'is_onboarded' => $this->isOnboarded,
            'is_verified' => $this->isVerified,

            'is_suspended' => $this->isSuspended,
            'suspension_reason' => $this->suspension_reason ? $this->suspension_reason->description : null,

            'subscription' => new SubscriptionResource($this),

            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
