<?php

namespace App\Models;

use App\Support\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use App\Support\Enums\MessageActionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alias extends Model
{
    use Uuid;
    use SoftDeletes;

    protected $fillable = [
//        'id',
//        'uuid',
        'user_id',
        'alias',
        'name',
        'message_action',
        'message_forward_to',
//        'created_at',
//        'updated_at',
//        'deleted_at',
    ];

    protected $enumCasts = [
        'message_action' => MessageActionType::class,
    ];

    /**
     * @return string
     */
    public function getCompleteAliasAttribute() : string
    {
        return sprintf(
            '%s.%s',
            $this->alias,
            $this->user->uuid
        );
    }

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
     * @return Relations\HasMany
     */
    public function messages() : Relations\HasMany
    {
        return $this->hasMany(
            Message::class,
            'alias_id',
            'id'
        );
    }

    /**
     * @param Builder $query
     * @param string $alias
     * @param string $name
     * @return Builder
     */
    public function scopeWhereCompleteAlias(Builder $query, string $alias, string $name) : Builder
    {
        return $query
            ->where('alias', '=', $alias)
            ->whereHas('user', function ($query) use ($name) {
                return $query->where('base_alias', '=', $name);
            })
        ;
    }

    /**
     * @param Builder $query
     * @param string $action
     * @return Builder
     */
    public function scopeWhereMessageAction(Builder $query, string $action) : Builder
    {
        return $query->where('message_action', $action);
    }

    /**
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'uuid';
    }
}
