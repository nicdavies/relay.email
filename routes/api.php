<?php

use App\Http\Controllers\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

# public
Route::group([], function () {
    Route::post('/auth/login', Api\Auth\LoginController::class);
    Route::post('/auth/register', Api\Auth\RegisterController::class);
    Route::post('/auth/forgot', Api\Auth\ForgotController::class);
    Route::post('/auth/reset', Api\Auth\ResetController::class);

    Route::post('/inbound', Api\Webhook\InboundController::class);
});

# auth
Route::group(['middleware' => ['auth:api']], function () {

    # account
    Route::get('/account', Api\Account\ReadController::class);
    Route::patch('/account', Api\Account\UpdateController::class);
    Route::delete('/account', Api\Account\DeleteController::class);

    # aliases
    Route::get('/aliases', Api\Alias\ListController::class);
    Route::post('/aliases', Api\Alias\CreateController::class);
    Route::get('/aliases/{alias}', Api\Alias\ReadController::class);
    Route::patch('/aliases/{alias}', Api\Alias\UpdateController::class);
    Route::delete('/aliases/{alias}', Api\Alias\DeleteController::class);

    # alias messages
    Route::get('/aliases/{alias}/messages', Api\Message\ListController::class);
    Route::get('/aliases/{alias}/messages/{message}', Api\Message\ReadController::class);
    Route::delete('/aliases/{alias}/messages/{message}', Api\Message\DeleteController::class);

});
