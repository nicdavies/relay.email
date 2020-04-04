<?php

namespace App\Http\Resources\Alias;

use Illuminate\Http\Request;
use App\Http\Resources\Base\PgpResource;
use App\Http\Resources\Base\OwnerResource;
use App\Http\Resources\Domain\DomainResource;
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
            'description' => $this->description,
            'is_pinned' => $this->is_pinned,

            'alias' => [
                'alias'    => $this->alias,
                'base'     => $this->user->base_alias,
                'domain'   => $this->domain ? $this->domain->custom_domain : config('app.app_mail_domain'),
                'complete' => $this->completeAlias,
                'complete_address' => $this->completeAliasAddress,
            ],

            'message_action' => $this->message_action->key,
            'message_forward_to' => $this->message_forward_to,
            'has_confirmed_message_forward_to' => $this->hasConfirmedForwardTo,
            'message_history_limit' => 999,

            'total_messages' => $this->totalMessages,
            'total_read_messages' => $this->totalReadMessages,
            'total_unread_messages' => $this->totalUnreadMessages,
            'latest_message_received_at' => $this->latestMessageReceivedTimestamp,
            'frequent_senders' => $this->mostFrequentSenders,

            'owner'  => new OwnerResource($this->user),

            'has_domain' => $this->hasCustomDomain,
            'domain' => new DomainResource($this->domain),

            'pgp_key'  => new PgpResource($this->encryptionKey),

            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
