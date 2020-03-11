<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = [
        'id',
        'email',
        'token',
        'created_at'
    ];

    public $timestamps = false;
    protected $dates = ['created_at'];

    /**
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'token';
    }
}
