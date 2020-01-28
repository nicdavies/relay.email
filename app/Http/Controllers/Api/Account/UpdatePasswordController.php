<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use App\Notifications\User\PasswordChangedNotification;

class UpdatePasswordController extends Controller
{
    /**
     * @param Request $request
     * @return UserResource
     * @throws ValidationException
     */
    public function __invoke(Request $request) : UserResource
    {
        /** @var User $user */
        $user = $request->user();

        $this->validate($request, [
            'current_password'     => ['required', 'string', 'password:web'],
            'new_password'         => ['required', 'string', 'min:6'],
            'confirm_new_password' => ['required', 'string', 'same:new_password'],
        ]);

        $user->update([
            'password' => Hash::make($request->get('new_password')),
        ]);

        Notification::send($user, new PasswordChangedNotification());

        return new UserResource($user);
    }
}
