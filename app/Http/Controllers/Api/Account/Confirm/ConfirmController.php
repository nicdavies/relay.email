<?php

namespace App\Http\Controllers\Api\Account\Confirm;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Encryption\DecryptException;

class ConfirmController extends Controller
{
    /**
     * @param Request $request
     * @return UserResource|JsonResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request, string $token)
    {
        /** @var User $user */
        $user = $request->user();

        // Decrypt token, grab uuid & email - find user and update them!
        try {
            $decryptedToken = decrypt($token);
        } catch (DecryptException $e) {
            return response()->json([
                'error'   => true,
                'message' => 'Failed to confirm token!',
            ]);
        }

        // Split the decrypted string to grab "uuid.email"
        $uuid = Str::before($decryptedToken, '.');
        $email = Str::after($decryptedToken, '.');

        if ($user->uuid !== $uuid || $user->email !== $email) {
            return response()->json([
                'error'   => true,
                'message' => 'Failed to confirm token!',
            ]);
        }

        $user->markEmailAsVerified();

        return new UserResource($user->fresh());
    }
}
