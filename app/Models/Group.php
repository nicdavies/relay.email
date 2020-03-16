<?php

namespace App\Models;

use App\Support\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use Uuid;
    use SoftDeletes;

    protected $fillable = [
//        'id',
//        'uuid',
//        'user_id',
        'name',
        'description',
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

    public function getRouteKeyName() : string
    {
        return 'uuid';
    }
}
