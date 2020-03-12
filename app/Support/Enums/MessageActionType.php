<?php

namespace App\Support\Enums;

use BenSampo\Enum\Enum;

class MessageActionType extends Enum
{
    public const SAVE = 'SAVE';
    public const IGNORE = 'IGNORE';
    public const FORWARD = 'FORWARD';
    public const FORWARD_AND_SAVE = 'FORWARD_AND_SAVE';

    /**
     * @param mixed $value
     * @return string
     */
    public static function getDescription($value) : string
    {
        switch ($value) {
            case self::SAVE:
                return 'save';
                break;

            case self::IGNORE:
                return 'ignore';
                break;

            case self::FORWARD:
                return 'forward';
                break;

            case self::FORWARD_AND_SAVE:
                return 'forward and save';
                break;

            default:
                return self::getKey($value);
        }
    }
}
