<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use App\Support\Gates\AliasGates;
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
        // 'App\Model' => 'App\Policies\ModelPolicy',
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
            AliasGates::rules(),
        );

        collect($rules)->each(function ($callback, $key) {
            Gate::define($key, $callback);
        });
    }
}
