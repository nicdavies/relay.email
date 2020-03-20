<?php

namespace App\Models;

use App\Support\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referral extends Model
{
    use Uuid;
    use SoftDeletes;

    protected $fillable = [
//        'id',
//        'uuid',
        'user_id',
        'referred_by_user_id',
//        'created_at',
//        'updated_at',
//        'deleted_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
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
     * @return Relations\BelongsTo
     */
    public function referredByUser() : Relations\BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'referred_by_user_id',
            'id'
        );
    }
}
