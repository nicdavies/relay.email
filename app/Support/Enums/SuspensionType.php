<?php

namespace App\Support\Enums;

use BenSampo\Enum\Enum;

class SuspensionType extends Enum
{
    const SPAM = 'SPAM';
    const ILLICIT_ACTIVITY = 'ILLICIT_ACTIVITY';

    /**
     * @param mixed $value
     * @return string
     */
    public static function getDescription($value) : string
    {
        switch ($value) {
            case self::SPAM:
                return 'Spam';
                break;

            case self::ILLICIT_ACTIVITY:
                return 'Illicit Activity';
                break;
        }

        return $value;
    }
}
