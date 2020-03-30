<?php

namespace App\Models;

use Laravolt\Avatar\Avatar;
use App\Support\Traits\Uuid;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use BenSampo\Enum\Traits\CastsEnums;
use App\Traits\NotificationSettings;
use Illuminate\Auth\MustVerifyEmail;
use Spatie\MediaLibrary\Models\Media;
use App\Support\Enums\SuspensionType;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Cviebrock\EloquentSluggable\Sluggable;
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
    use Sluggable;
    use Notifiable;
    use CastsEnums;
    use HasApiTokens;
    use HasMediaTrait;
    use MustVerifyEmail;
    use NotificationSettings;

    protected $fillable = [
//        'id',
//        'uuid',
        'slug',
        'name',
        'email',
        'password',
        'notification_settings',
        'email_verified_at',
        'onboarded_at',
        'base_alias',
        'referral_code',
        'card_brand',
        'card_last_four',
        'last_action_at',
        'suspended_at',
        'suspension_reason',
//        'is_admin',
//        'created_at',
//        'updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'notification_settings',
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
        'is_admin' => 'boolean',
    ];

    protected $enumCasts = [
        'suspension_reason' => SuspensionType::class,
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

        $avatar = new Avatar([]);
        return $avatar->create($this->name)->toBase64();
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
     * @return string
     */
    public function getReferralLinkAttribute() : string
    {
        return sprintf(
            '%s/auth/register?invite=%s',
            config('app.url'),
            $this->referral_code,
        );
    }

    /**
     * @return bool
     */
    public function getIsSuspendedAttribute() : bool
    {
        return $this->suspended_at !== null;
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
     * @param Builder $builder
     * @param $referralCode
     * @return Builder
     */
    public function scopeWhereReferralCode(Builder $builder, $referralCode) : Builder
    {
        return $builder->where('referral_code', $referralCode);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeWhereNotSuspended(Builder $builder) : Builder
    {
        return $builder->whereNull('suspended_at');
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
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
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

    /**
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'uuid';
    }
}
