<?php

namespace App\Models;

use App\Support\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;

class PgpKey extends Model
{
    use Uuid;
    use SoftDeletes;

    protected $table = 'pgp_keys';

    protected $fillable = [
//        'id',
//        'uuid',
//        'user_id',
        'public_key',
        'is_default',
//        'created_at',
//        'updated_at',
//        'deleted_at',
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
