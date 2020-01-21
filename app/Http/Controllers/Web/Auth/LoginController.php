<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|RedirectResponse|View
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('auth.login');
        }

        $this->validate($request, [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:3'],
        ]);

        /** @var User|null $user */
        $user = User::where('email', $request->get('email'))->first();

        if ($user === null) {
            // todo - flash message with error
            return back();
        }

        if (! password_verify($request->get('password'), $user->getAuthPassword())) {
            // todo - flash message with error
            return back();
        }

        Auth::login($user);
        return response()->redirectToRoute('home');
    }
}
