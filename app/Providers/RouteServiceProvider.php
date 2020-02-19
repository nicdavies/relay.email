<?php

namespace App\Providers;

use App\Models;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot() : void
    {
        parent::boot();
        Route::model('key', Models\EncryptionKey::class);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map() : void
    {
        $this->mapApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->group(base_path('routes/api.php'))
        ;
    }
}
