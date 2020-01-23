<?php

use App\Http\Controllers\Web;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# public
Route::group([], function () {

    # frontend
    Route::get('/', Web\Frontend\IndexController::class)->name('frontend.index');
    Route::get('/about', Web\Frontend\AboutController::class)->name('frontend.about');
    Route::get('/pricing', Web\Frontend\PricingController::class)->name('frontend.pricing');

    # auth
    Route::get('/auth/login', Web\Auth\LoginController::class)->name('auth.login');
    Route::post('/auth/login', Web\Auth\LoginController::class)->name('auth.login.post');

    Route::get('/auth/register', Web\Auth\RegisterController::class)->name('auth.register');
    Route::post('/auth/register', Web\Auth\RegisterController::class)->name('auth.register.post');

    Route::get('/auth/forgot', 'App\Http\Controllers\Web\Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.forgot');
    Route::post('/auth/forgot', 'App\Http\Controllers\Web\Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.forgot.post');

    Route::get('/auth/reset/{token}', 'App\Http\Controllers\Web\Auth\ResetPasswordController@showResetForm')->name('auth.reset');
    Route::post('/auth/reset/{token}', 'App\Http\Controllers\Web\Auth\ResetPasswordController@reset')->name('auth.reset.post');

});

# auth
Route::group(['auth'], function () {

    # welcome / onboarding
    Route::get('/welcome', Web\Misc\WelcomeController::class)->name('welcome');
    Route::post('/welcome', Web\Misc\WelcomeController::class)->name('welcome.post');

    # auth
    Route::post('/logout', Web\Auth\LogoutController::class)->name('auth.logout');

    # account
    Route::get('/account', Web\Account\ReadController::class)->name('account');
    Route::patch('/account/general', Web\Account\Update\GeneralController::class)->name('account.update.general');
    Route::patch('/account/gpg', Web\Account\Update\GpgController::class)->name('account.update.gpg');
    Route::patch('/account/password', Web\Account\Update\PasswordController::class)->name('account.update.password');
    Route::delete('/account', Web\Account\DeleteController::class)->name('account.destroy');

    # requires user to be onboarded!
    Route::group(['middleware' => ['verified', 'onboarded']], function () {

        # misc
        Route::get('/home', Web\Misc\DashboardController::class)->name('home');

        # aliases
        Route::get('/aliases/create', Web\Alias\CreateController::class)->name('alias.create');
        Route::post('/aliases/create', Web\Alias\CreateController::class)->name('alias.store');
        Route::get('/aliases/{alias}', Web\Alias\ReadController::class)->name('alias.show');
        Route::delete('/aliases/{alias}', Web\Alias\DeleteController::class)->name('alias.destroy');

        # alias settings
        Route::get('/aliases/{alias}/settings', Web\Alias\UpdateController::class)->name('alias.settings');
        Route::patch('/aliases/{alias}/settings/general', Web\Alias\Update\GeneralController::class)->name('alias.update.general');
        Route::patch('/aliases/{alias}/settings/action', Web\Alias\Update\ActionController::class)->name('alias.update.action');
        Route::get('/aliases/{alias}/settings/forward-confirm/{token}', Web\Alias\Update\ForwardConfirmController::class)->name('alias.update.forward.confirm');

        # alias inbox
        Route::get('/aliases/{alias}/inbox', Web\Message\ListController::class)->name('inbox.list');
        Route::get('/aliases/{alias}/inbox/message/{message}', Web\Message\ReadController::class)->name('inbox.message.read');
        Route::post('/aliases/{alias}/inbox/message/{message}/forward', Web\Message\ForwardController::class)->name('inbox.message.forward');
        Route::post('/aliases/{alias}/inbox/message/{message}/archive', Web\Message\ArchiveController::class)->name('inbox.message.archive');
        Route::delete('/aliases/{alias}/inbox/message/{message}', Web\Message\DeleteController::class)->name('inbox.message.delete');

        # billing
        Route::get('/billing', Web\Billing\ReadController::class)->name('billing');

    });

});
