<?php

namespace App\Http\Resources\Alias;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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

            'from' => [
                'name' => $this->from_name,
                'email' => $this->from_email,
            ],

            'total_attachments' => $this->attachment_count,
            'properties' => $this->properties,
            'intro_line' => $this->intro_line,

            'is_read' => $this->is_read,
            'read_at' => $this->read_at ? $this->read_at->toIso8601String() : null,

            'has_preview_token' => $this->has_preview_token,
            'preview_token' => $this->preview_token,

            'body' => [
                'has_html' => $this->hasHtmlMessage,
                'has_plain' => $this->hasPlainTextMessage,
            ],

            'spam' => [
                'score' => $this->spam_score,
                'is_spam' => $this->isSpam,
            ],

            'attachments' => AttachmentResource::collection($this->getMedia('attachments')),

            'alias' => new BaseAliasResource($this->alias),

            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
