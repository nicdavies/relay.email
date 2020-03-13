<?php

namespace App\Http\Resources\Alias;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EncryptionKey\EncryptionKeyResource;
use App\Http\Resources\Base\AliasResource as BaseAliasResource;

class MessageResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array|void
     */
    public function toArray($request) : array
    {
        return [
            'uuid' => $this->uuid,
            'subject' => $this->subject,
            'from' => $this->from,
            'sender' => $this->sender,
            'total_attachments' => $this->attachment_count,
            'properties' => $this->properties,

            'is_read' => $this->isRead,
            'read_at' => $this->read_at ? $this->read_at->toIso8601String() : null,

            'body' => [
                'has_html' => $this->hasHtmlMessage,
                'html' => $this->body_html,

                'has_plain' => $this->hasPlainTextMessage,
                'plain' => $this->body_plain,
            ],

            'attachments' => AttachmentResource::collection($this->getMedia('attachments')),

            'alias' => new BaseAliasResource($this->alias),

            'is_encrypted' => $this->isEncrypted,
            'encryption_key' => new EncryptionKeyResource($this->encryptionKey),

            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
