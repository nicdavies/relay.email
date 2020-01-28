<?php

namespace App\Http\Resources\Alias;

use Illuminate\Http\Request;
use App\Http\Resources\Base\OwnerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AliasResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'alias' => $this->alias,
            'complete_alias' => $this->completeAlias,

            'message_action' => $this->message_action,
            'message_forward_to' => $this->message_forward_to,
            'has_confirmed_message_forward_to' => $this->hasConfirmedForwardTo,
            'total_messages' => $this->messages->count(),
            'message_limit' => $this->message_limit,

            'owner' => new OwnerResource($this->user),

            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
