<?php

namespace App\Support\Traits;

use App\Support\Helpers\Str;

trait Uuid
{
    /**
     * @return void
     */
    public static function bootUuid() : void
    {
        static::creating(static function ($model) {
            $model->uuid = Str::nanoId();
        });
    }
}
