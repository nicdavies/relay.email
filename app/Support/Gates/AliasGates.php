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
            'alias-message-read' => function (User $user, Alias $alias, Message $message) {
                return $alias->id === $message->alias_id;
            },
            'alias-message-delete' => function (User $user, Alias $alias, Message $message) {
                return $alias->id === $message->alias_id;
            },
        ];
    }
}
