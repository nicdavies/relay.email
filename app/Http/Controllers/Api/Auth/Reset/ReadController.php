<?php

namespace App\Http\Controllers\Api\Auth\Reset;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @param PasswordReset $passwordReset
     * @return JsonResponse
     */
    public function __invoke(Request $request, PasswordReset $passwordReset) : JsonResponse
    {
        return response()->json([
            'success' => true,
        ]);
    }
}
