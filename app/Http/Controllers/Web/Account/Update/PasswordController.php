<?php

namespace App\Http\Controllers\Web\Account\Update;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use App\Notifications\User\PasswordChangedNotification;

class PasswordController extends Controller
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

        $this->validate($request, [
            'current_password' => ['required', 'string', 'password:web'],
            'new_password' => ['required', 'string', 'min:6'],
            'confirm_new_password' => ['required', 'string', 'same:new_password'],
        ]);

        $user->update([
            'password' => Hash::make($request->get('new_password')),
        ]);

        Notification::send($user, new PasswordChangedNotification());

        return back();
    }
}
