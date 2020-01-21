<?php

namespace App\Support\Enums;

use BenSampo\Enum\Enum;

class MessageActionType extends Enum
{
    public const SAVE = 'SAVE';
    public const IGNORE = 'IGNORE';
    public const FORWARD = 'FORWARD';
    public const FORWARD_AND_SAVE = 'FORWARD_AND_SAVE';
}
