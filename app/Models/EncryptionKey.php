<?php

namespace App\Models;

use App\Support\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;

class EncryptionKey extends Model
{
    use Uuid;
    use SoftDeletes;

    protected $table = 'encryption_keys';

    protected $fillable = [
//        'id',
//        'uuid',
        'public_key',
        'is_default',
//        'created_at',
//        'updated_at',
//        'deleted_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * @return Relations\BelongsTo
     */
    public function user() : Relations\BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWhereDefault(Builder $query) : Builder
    {
        return $query
            ->where('is_default', true)
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
