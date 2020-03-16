<?php

namespace App\Support\Gates;

use App\Models\User;
use App\Models\Group;

class GroupGates implements Contract
{
    /**
     * @return array
     */
    public static function rules() : array
    {
        return [
            'owns-group' => function (User $user, Group $group) {
                return $user->id === $group->user_id;
            },
        ];
    }
}
