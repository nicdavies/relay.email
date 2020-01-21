<?php

namespace App\Providers;

use App\Support\Services\Api\Client;
use Illuminate\Support\ServiceProvider;
use Mailgun\Mailgun;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() : void
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->app->bind(Mailgun::class, function () {
            return Mailgun::create('', '');
        });

        $this->app->bind(Client::class, function () {
            $endpoint = config('api.endpoint');
            $secret   = config('api.client_secret');

            return new Client($endpoint, $secret);
        });
    }
}
