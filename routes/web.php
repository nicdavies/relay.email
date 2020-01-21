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

    Route::post('/auth/forgot', 'App\Http\Controllers\Web\Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.forgot');
    Route::post('/auth/reset/{token}', 'App\Http\Controllers\Web\Auth\ResetPasswordController@reset')->name('auth.reset');

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
    Route::patch('/account', Web\Account\UpdateController::class)->name('account.update');
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
        Route::patch('/aliases/{alias}', Web\Alias\UpdateController::class)->name('alias.update');
        Route::delete('/aliases/{alias}', Web\Alias\DeleteController::class)->name('alias.destroy');

        # alias messages
        Route::get('/aliases/{alias}/inbox', Web\Message\ListController::class)->name('inbox.list');
        Route::get('/aliases/{alias}/inbox/message/{message}', Web\Message\ReadController::class)->name('inbox.message.read');
        Route::delete('/aliases/{alias}/inbox/message/{message}', Web\Message\DeleteController::class)->name('inbox.message.delete');

    });

});
