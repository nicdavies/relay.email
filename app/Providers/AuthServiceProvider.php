<?php

namespace App\Providers;

use App\Support\Gates;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     * @return void
     */
    public function boot() : void
    {
        $this->registerPolicies();
        Passport::routes();
    }

    /**
     * @return void
     */
    public function register() : void
    {
        $rules = array_merge(
            Gates\AliasGates::rules(),
            Gates\EncryptionKeyGates::rules(),
        );

        collect($rules)->each(function ($callback, $key) {
            Gate::define($key, $callback);
        });
    }
}
