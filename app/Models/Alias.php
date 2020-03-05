<?php

namespace App\Models;

use App\Support\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use App\Support\Enums\MessageActionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alias extends Model
{
    use Uuid;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
//        'id',
//        'uuid',
        'user_id',
        'alias',
        'name',
        'description',
        'message_action',
        'message_forward_to',
        'forward_to_confirmed_at',
        'forward_to_confirmation_token',
        'encryption_key_id',
        'custom_domain_id',
//        'created_at',
//        'updated_at',
//        'deleted_at',
    ];

    protected $enumCasts = [
        'message_action' => MessageActionType::class,
    ];

    protected static $logFillable = true;

    /**
     * @return string
     */
    public function getCompleteAliasAttribute() : string
    {
        // If there's a custom domain - then we don't need the base_alias!
        if ($this->hasCustomDomain) {
            return sprintf(
                '%s',
                $this->alias
            );
        }

        return sprintf(
            '%s.%s',
            $this->alias,
            $this->user->base_alias
        );
    }

    /**
     * @return string
     */
    public function getCompleteAliasAddressAttribute() : string
    {
        // If there's a custom domain - then we don't need the base_alias!
        if ($this->hasCustomDomain) {
            return sprintf(
                '%s@%s',
                $this->alias,
                $this->domain->custom_domain
            );
        }

        return sprintf(
            '%s.%s@%s',
            $this->alias,
            $this->user->base_alias,
            config('app.app_mail_domain')
        );
    }

    /**
     * @return bool
     */
    public function getHasConfirmedForwardToAttribute() : bool
    {
        return $this->forward_to_confirmed_at !== null;
    }

    /**
     * @return bool
     */
    public function getHasCustomDomainAttribute() : bool
    {
        return $this->custom_domain_id !== null;
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
     * @return Relations\BelongsTo
     */
    public function domain() : Relations\BelongsTo
    {
        return $this->belongsTo(
            CustomDomain::class,
            'custom_domain_id',
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
