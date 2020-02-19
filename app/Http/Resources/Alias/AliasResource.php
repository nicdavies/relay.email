<?php

namespace App\Http\Resources\Alias;

use App\Http\Resources\Base\PgpResource;
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

            'alias' => [
                'alias'    => $this->alias,
                'base'     => $this->user->base_alias,
                'complete' => $this->completeAlias,
            ],

            'message_action' => $this->message_action,
            'message_forward_to' => $this->message_forward_to,
            'has_confirmed_message_forward_to' => $this->hasConfirmedForwardTo,
            'total_messages' => $this->messages->count(),
            'message_history_limit' => 999, // todo - this is based on the current plan

            'owner' => new OwnerResource($this->user),
            'pgp_key' => new PgpResource($this->encryptionKey),
            'activity' => ActivityResource::collection($this->activities->sortByDesc('created_at')->take(8)),

            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
