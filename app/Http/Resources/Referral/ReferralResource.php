<?php

namespace App\Http\Resources\Referral;

use App\Http\Resources\Base\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReferralResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'user' => new UserResource($this->referred_by_user),
            'referred_user' => new UserResource($this->user),
        ];
    }
}
