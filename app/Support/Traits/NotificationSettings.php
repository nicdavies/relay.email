<?php

declare(strict_types=1);

namespace App\Traits;

use App\Helpers\NotificationSettings as NotificationSettingsHelper;

trait NotificationSettings
{
    /**
     * @return array
     */
    public function getNotificationSettings() : array
    {
        /** @var array|null $userNotifications */
        $userNotifications = $this->notification_settings;

        if ($userNotifications === null) {
            $userNotifications = [];
        }

        return array_merge(NotificationSettingsHelper::getTypes(), $userNotifications);
    }
}
