<?php

namespace App\Models;

use App\Support\Traits\Uuid;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Image\Exceptions\InvalidManipulation;

class Message extends Model implements HasMedia
{
    use Uuid;
    use SoftDeletes;
    use HasMediaTrait;

    protected $table = 'alias_messages';

    protected $fillable = [
//        'id',
//        'uuid',
//        'alias_id',
        'subject',
        'from',
        'sender',
        'body_html',
        'body_plain',
        'attachment_count',
        'properties',
        'raw_payload',
        'token',
        'signature',
        'encryption_key_id',
        'is_hidden',
//        'created_at',
//        'updated_at',
//        'deleted_at',
    ];

    protected $casts = [
        'raw_payload' => 'array',
        'properties' => 'array',
        'is_hidden' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * @return bool
     */
    public function getIsEncryptedAttribute() : bool
    {
        return $this->encryptionKey instanceof EncryptionKey;
    }

    /**
     * @return Relations\BelongsTo
     */
    public function alias() : Relations\BelongsTo
    {
        return $this->belongsTo(
            Alias::class,
            'alias_id',
            'id'
        );
    }

    /**
     * @return Relations\BelongsTo
     */
    public function encryptionKey() : Relations\BelongsTo
    {
        return $this->belongsTo(
            EncryptionKey::class,
            'encryption_key_id',
            'id'
        );
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithoutHidden(Builder $query) : Builder
    {
        return $query->where('is_hidden', false);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOnlyHidden(Builder $query) : Builder
    {
        return $query->where('is_hidden', true);
    }

    /**
     * @return void
     */
    public function registerMediaCollections() : void
    {
        $this
            ->addMediaCollection('attachments')
        ;
    }

    /**
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'uuid';
    }
}
