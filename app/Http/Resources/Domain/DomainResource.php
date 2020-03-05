<?php

namespace App\Http\Resources\Domain;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DomainResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'uuid' => $this->uuid,
            'domain' => $this->custom_domain,

            'is_verified' => $this->isVerified,
            'verified_at' => $this->verified_at ? $this->verified_at->toIso8601String() : null,
            'verification_code' => $this->verification_code,

            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
