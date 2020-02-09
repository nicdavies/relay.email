<?php

namespace App\Support\Gates;

use App\Models\User;
use App\Models\PgpKey;

class PgpGates implements Contract
{
    /**
     * @return array
     */
    public static function rules(): array
    {
        return [
            'owns-pgp-key' => function (User $user, PgpKey $pgpKey) {
                return $user->id === $pgpKey->user_id;
            },
        ];
    }
}
