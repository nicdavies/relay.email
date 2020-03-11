<?php

namespace App\Http\Controllers\Api\Auth\Reset;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UpdateController extends Controller
{
    /**
     * @param Request $request
     * @param PasswordReset $passwordReset
     * @return JsonResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request, PasswordReset $passwordReset)
    {
        $this->validate($request, [
            'password'         => ['required', 'string', 'min:3', 'max:150'],
            'confirm_password' => ['required', 'string', 'same:password'],
        ]);

        /** @var User|null $user */
        $user = User::where('email', $passwordReset->email)->first();

        if (! $user instanceof User) {
            return response()->json([
                'error'   => true,
                'message' => 'Unknown error',
            ], 400);
        }

        // Delete the token so it can't be re-used and then update the password
        $passwordReset->delete();

        $user->update([
            'password' => Hash::make($request->get('password')),
        ]);

        return response()->json([
            'success' => true,
        ]);
    }
}
