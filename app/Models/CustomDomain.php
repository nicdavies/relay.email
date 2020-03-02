<?php

namespace App\Models;

use Carbon\Carbon;
use App\Support\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomDomain extends Model
{
    use Uuid;
    use SoftDeletes;

    protected $table = 'custom_domains';

    protected $fillable = [
//        'id',
//        'uuid',
//        'user_id',
        'custom_domain',
        'verified_at',
        'verification_code',
//        'created_at',
//        'updated_at',
//        'deleted_at',
    ];

    protected $dates = [
        'verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return bool
     */
    public function getIsVerifiedAttribute() : bool
    {
        return $this->verified_at instanceof Carbon
            && $this->verified_at->isPast();
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
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'uuid';
    }
}
