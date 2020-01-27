<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use App\Support\Traits\Uuid;
use Laravel\Passport\HasApiTokens;
use App\Traits\NotificationSettings;
use Illuminate\Auth\MustVerifyEmail;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\Relations;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Image\Exceptions\InvalidManipulation;
use App\Notifications\User\VerifyEmailNotification;
use App\Notifications\User\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use Uuid;
    use Billable;
    use Notifiable;
    use HasApiTokens;
    use HasMediaTrait;
    use MustVerifyEmail;
    use NotificationSettings;

    protected $fillable = [
//        'id',
//        'uuid',
        'name',
        'email',
        'password',
        'notification_settings',
        'email_verified_at',
        'onboarded_at',
        'base_alias',
        'old_aliases',
//        'created_at',
//        'updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'notification_settings',
    ];

    protected $casts = [
        'onboarded_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'notification_settings' => 'array',
        'old_aliases' => 'array',
    ];

    /**
     * @return string
     */
    public function getAvatarAttribute() : string
    {
        $avatar = $this->getFirstMedia('avatar');

        if ($avatar !== null) {
            return $avatar->getFullUrl();
        }

        return '/img/avatar.jpg';
    }

    /**
     * @return bool
     */
    public function getIsOnboardedAttribute() : bool
    {
        return $this->onboarded_at !== null && $this->onboarded_at->isPast();
    }

    /**
     * @return bool
     */
    public function getIsVerifiedAttribute() : bool
    {
        return $this->hasVerifiedEmail();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|Relations\HasMany|object|null
     */
    public function getCurrentGpgKeyAttribute()
    {
        return $this
            ->gpgKeys()
            ->orderByDesc('created_at')
            ->first()
        ;
    }

    /**
     * @return Relations\HasMany
     */
    public function aliases() : Relations\HasMany
    {
        return $this->hasMany(
            Alias::class,
            'user_id',
            'id'
        );
    }

    /**
     * @return Relations\HasMany
     */
    public function gpgKeys() : Relations\HasMany
    {
        return $this->hasMany(
            GpgKey::class,
            'user_id',
            'id'
        );
    }

    /**
     * @return void
     */
    public function registerMediaCollections() : void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile()
        ;
    }

    /**
     * @param Media|null $media
     * @throws InvalidManipulation
     * @return void
     */
    public function registerMediaConversions(Media $media = null) : void
    {
        $this
            ->addMediaConversion('thumbnail')
            ->fit('FIT_CONTAIN', 256, 256)
            ->performOnCollections('avatar')
        ;
    }

    /**
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'uuid';
    }

    /**
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token) : void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @return void
     */
    public function sendEmailVerificationNotification() : void
    {
        $this->notify(new VerifyEmailNotification());
    }
}
