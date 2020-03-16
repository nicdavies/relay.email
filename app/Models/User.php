<?php

namespace App\Models;

use App\Support\Traits\Uuid;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use App\Traits\NotificationSettings;
use Illuminate\Auth\MustVerifyEmail;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
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
        'referral_code',
        'referred_by_user_id',
        'card_brand',
        'card_last_four',
        'last_action_at',
//        'is_admin',
//        'created_at',
//        'updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'notification_settings',
        'old_aliases',
    ];

    protected $dates = [
        'trial_ends_at',
        'last_action_at',
    ];

    protected $casts = [
        'onboarded_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'custom_domain_verified_at' => 'datetime',
        'notification_settings' => 'array',
        'old_aliases' => 'array',
        'is_admin' => 'boolean',
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
     * @return bool
     */
    public function getWasReferredAttribute() : bool
    {
        return $this->referred_by_user !== null;
    }

    /**
     * @return string
     */
    public function getReferralLinkAttribute() : string
    {
        return sprintf(
            '%s/auth/register?code=%s',
            config('app.url'),
            $this->referral_code,
        );
    }

    /**
     * @return Relations\HasMany
     */
    public function groups() : Relations\HasMany
    {
        return $this->hasMany(
            Group::class,
            'user_id',
            'id'
        );
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
     * @return Relations\HasManyThrough
     */
    public function messages() : Relations\HasManyThrough
    {
        return $this->hasManyThrough(
            Message::class,
            Alias::class,
            'user_id',
            'alias_id',
            );
    }

    /**
     * @return Relations\HasMany
     */
    public function encryptionKeys() : Relations\HasMany
    {
        return $this->hasMany(
            EncryptionKey::class,
            'user_id',
            'id'
        );
    }

    /**
     * @return Relations\BelongsTo
     */
    public function referredByUser() : Relations\BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'referred_by_user_id',
            'id'
        );
    }

    /**
     * @return Relations\HasMany
     */
    public function customDomains() : Relations\HasMany
    {
        return $this->hasMany(
            CustomDomain::class,
            'user_id',
            'id'
        );
    }

    /**
     * @return Relations\HasMany
     */
    public function referrals() : Relations\HasMany
    {
        return $this->hasMany(
            User::class,
            'referred_by_user_id',
            'id'
        );
    }

    /**
     * @param Builder $builder
     * @param $referralCode
     * @return Builder
     */
    public function scopeWhereReferralCode(Builder $builder, $referralCode) : Builder
    {
        return $builder->where('referral_code', $referralCode);
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
