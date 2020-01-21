<?php

namespace App\Http\Controllers\Web\Account\Update;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class GeneralController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request) : RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        // Since the user can change their email address, we only want to validate if it's changed
        $rules = [
            'name' => ['sometimes', 'string', 'min:3', 'max:20'],
        ];

        if ($request->get('email') !== $user->email) {
            $rules['email'] = ['sometimes', 'email', 'unique:users,email'];
        }

        $this->validate($request, $rules);

        $user->update([
            'name'  => $request->get('name', $user->name),
            'email' => $request->get('email', $user->email),
        ]);

        return back();
    }
}
