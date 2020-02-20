<?php

namespace App\Support\Gates;

use App\Models\User;
use App\Models\EncryptionKey;

class EncryptionKeyGates implements Contract
{
    /**
     * @return array
     */
    public static function rules(): array
    {
        return [
            'owns-encryption-key' => function (User $user, EncryptionKey $key) {
                return $user->id === $key->user_id;
            },
        ];
    }
}
