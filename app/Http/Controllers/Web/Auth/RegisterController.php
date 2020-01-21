<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

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

        $user = User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'base_alias' => hash('crc32', random_bytes(8)),
        ]);

        Auth::login($user);
        return response()->redirectToRoute('welcome');
    }
}
