<?php

declare(strict_types=1);

namespace App\Rules;

use App\Helpers\NotificationSettings;
use Illuminate\Contracts\Validation\Rule;

class NotificationJsonRule implements Rule
{
    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /** @var array $types */
        $types = NotificationSettings::getTypes();

        foreach ($value as $key => $item) {
            // check if the notification type exists
            if (! array_key_exists($key, $types)) {
                return false;
            }

            // check if the channels exist and the $ch value is a bool
            foreach ($item as $channelName => $v) {
                if (! array_key_exists($channelName, $types[$key]['channels'])) {
                    return false;
                }

                if (! is_bool($types[$key]['channels'][$channelName])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @return array|string
     */
    public function message()
    {
        return 'Invalid notification json structure';
    }
}
