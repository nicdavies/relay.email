<?php

namespace App\Support\Gates;

use App\Models\User;
use App\Models\CustomDomain;

class DomainGates implements Contract
{
    /**
     * @return array
     */
    public static function rules(): array
    {
        return [
            'owns-domain' => function (User $user, CustomDomain $domain) {
                return $user->id === $domain->user_id;
            },
        ];
    }
}
