<?php

namespace App\Support\Gates;

use App\Models\Alias;
use App\Models\Message;
use App\Models\User;

class AliasGates implements Contract
{
    /**
     * @return array
     */
    public static function rules(): array
    {
        return [
            'owns-alias' => function (User $user, Alias $alias) {
                return $user->id === $alias->user_id;
            },
            'owns-message' => function (User $user, Message $message) {
                return $user->id === $message->alias->user->id;
            },
        ];
    }
}
