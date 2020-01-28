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

    Route::post('/message/inbound', Api\Webhook\InboundController::class);
});

# auth
Route::group(['middleware' => ['auth:api']], function () {

    # account
    Route::get('/account', Api\Account\ReadController::class);
    Route::patch('/account/general', Api\Account\UpdateGeneralController::class);
    Route::patch('/account/gpg', Api\Account\UpdateGpgController::class);
    Route::patch('/account/password', Api\Account\UpdatePasswordController::class);
    Route::delete('/account', Api\Account\DeleteController::class);

    # aliases
    Route::get('/aliases', Api\Alias\ListController::class);
    Route::post('/aliases', Api\Alias\CreateController::class);
    Route::get('/aliases/analytics', Api\Analytics\Alias\ReadController::class);
    Route::get('/aliases/{alias}', Api\Alias\ReadController::class);
    Route::patch('/aliases/{alias}/general', Api\Alias\UpdateGeneralController::class);
    Route::patch('/aliases/{alias}/action', Api\Alias\UpdateActionController::class);
    Route::delete('/aliases/{alias}', Api\Alias\DeleteController::class);

    # alias messages
    Route::get('/aliases/{alias}/messages', Api\Message\ListController::class);
    Route::get('/aliases/{alias}/messages/{message}', Api\Message\ReadController::class);
    Route::post('/aliases/{alias}/messages/{message}/forward', Api\Message\ForwardController::class);
    Route::post('/aliases/{alias}/messages/{message}/archive', Api\Message\ArchiveController::class);
    Route::delete('/aliases/{alias}/messages/{message}', Api\Message\DeleteController::class);

//    # billing
//    Route::get('/billing', Web\Billing\ReadController::class)->name('billing');
//    Route::post('/billing/card', Web\Billing\Card\CreateController::class)->name('billing.card.store');
//    Route::delete('/billing/card', Web\Billing\Card\DeleteController::class)->name('billing.card.destroy');
//    Route::post('/billing/subscription', Web\Billing\Subscription\CreateController::class)->name('billing.subscription.start');
//    Route::delete('/billing/subscription', Web\Billing\Subscription\DeleteController::class)->name('billing.subscription.cancel');
//    Route::get('/billing/invoice/{invoice}', Web\Billing\Invoice\ReadController::class)->name('billing.invoice');

});
