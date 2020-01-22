<?php

namespace App\Models;

use App\Support\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;

class GpgKey extends Model
{
    use Uuid;
    use SoftDeletes;

    protected $table = 'gpg_keys';

    protected $fillable = [
//        'id',
//        'uuid',
//        'user_id',
        'gpg_key',
//        'created_at',
//        'updated_at',
//        'deleted_at',
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
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'uuid';
    }
}
