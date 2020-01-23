<?php

namespace App\Http\Controllers\Web\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|RedirectResponse|View
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('auth.register');
        }

        $this->validate($request, [
            'name'  => ['required', 'string', 'min:3', 'max:12'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'max:100'],
            'confirm_password' => ['same:password'],
        ]);

        /** @var User $user */
        $user = User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'base_alias' => hash('crc32', random_bytes(8)),
        ]);

        $user->createAsStripeCustomer();

        Auth::login($user);
        return response()->redirectToRoute('welcome');
    }
}
