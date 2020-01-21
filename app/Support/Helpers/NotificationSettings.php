<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Arr;
use App\Traits\NotificationSettings as NotificationSettingsTrait;

class NotificationSettings
{
    /**
     * Returns (bool)whether or not you can send a particular notification
     * to a particular eloquent model over the specified channel.
     *
     * @param $notifiable - Instance of elqouent model that has NotificationSettings trait attached.
     * @param string $notification the name of the notification to send.
     * @param string $channel - Delivery method (ie: web, mail).
     * @return bool
     */
    public static function canSend($notifiable, string $notification, string $channel) : bool
    {
        if (! in_array(NotificationSettingsTrait::class, class_uses_recursive($notifiable))) {
            return false;
        }

        /** @var array $notificationSettings */
        $notificationSettings = $notifiable->getNotificationSettings();

        if (! array_key_exists($notification, $notificationSettings)) {
            return false;
        }

        $notif = $notificationSettings[$notification];

        if (! Arr::has($notif, 'channels')) {
            return false;
        }

        if (! Arr::has($notif, 'channels.' . $channel)) {
            return false;
        }

        return Arr::get($notif, 'channels.' . $channel);
    }

    /**
     * @return array
     */
    public static function getTypes() : array
    {
        return config('notifications', []);
    }

    /**
     * @return array
     */
    public static function getTypeKeys() : array
    {
        return array_keys(self::getTypes());
    }
}
