<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static QUEUED()
 * @method static static PROCESSING()
 * @method static static COMPLETED()
 */
final class StatusType extends Enum
{
    const QUEUED = 'QUEUED';
    const PROCESSING = 'PROCESSING';
    const COMPLETED = 'COMPLETED';
}
