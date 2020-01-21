<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return UserResource|JsonResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        /** @var User|null $user */
        $user = User::where('email', $request->get('email'));

        if ($user === null) {
            return response()->json([
                'error'   => true,
                'message' => 'Invalid credentials',
            ]);
        }

        if (! password_verify($request->get('password'), $user->getAuthPassword())) {
            return response()->json([
                'error'   => true,
                'message' => 'Invalid credentials',
            ]);
        }

        return new UserResource($user);
    }
}
