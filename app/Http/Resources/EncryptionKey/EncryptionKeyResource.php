<?php

namespace App\Http\Resources\EncryptionKey;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EncryptionKeyResource extends JsonResource
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
            'is_default' => $this->is_default,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
