<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExposedEmail extends Model
{
    use SoftDeletes;

    protected $fillable = [
//        'id',
        'email_hash',
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
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'email_hash';
    }
}
