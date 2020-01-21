<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LogoutController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function __invoke(Request $request) : RedirectResponse
    {
        Auth::logout();
        return response()->redirectToRoute('auth.login');
    }
}
