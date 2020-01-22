<?php

namespace App\Http\Controllers\Web\Account;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class DeleteController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function __invoke(Request $request) : RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        // Let's soft-delete the user, log them out and then just redirect!
        $user->delete();
        Auth::logout();

        return response()->redirectToRoute('frontend.index');
    }
}
