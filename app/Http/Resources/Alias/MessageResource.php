<?php

namespace App\Http\Resources\Alias;

use Illuminate\Http\Request;
use App\Http\Resources\Base\OwnerResource;
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
            'from' => $this->from,
            'sender' => $this->sender,
            'total_attachments' => $this->attachment_count,
            
            'body' => [
                'html' => $this->body_html,
                'plain' => $this->body_plain,
            ],
            
            'attachments' => AttachmentResource::collection($this->getMedia('attachments')),
            
            'alias' => new BaseAliasResource($this->alias),
            
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}