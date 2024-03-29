<?php

namespace App\Http\Controllers\Api\Account\Confirm;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ResendController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request) : JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        // Resend the verification notification
        $user->sendEmailVerificationNotification();

        return response()->json([
            'success' => true,
        ]);
    }
}
