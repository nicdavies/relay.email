<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Support\Helpers\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Notifications\User\ResetPasswordNotification;

class ForgotController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
        ]);

        /** @var User $user */
        $user = User::where('email', $request->get('email'))->first();

        // If the user exists, we want to send the email
        if ($user instanceof User) {
            /** @var PasswordReset $passwordReset */
            $passwordReset = PasswordReset::create([
                'email' => $request->get('email'),
                'token' => Str::nanoId(),
            ]);

            $user->notify(new ResetPasswordNotification($passwordReset));
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
