<?php

namespace App\Http\Controllers\Api\Alias\Verify;

use Carbon\Carbon;
use App\Models\Alias;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alias\AliasResource;
use Illuminate\Validation\ValidationException;

class UpdateController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return AliasResource|JsonResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request, Alias $alias)
    {
        $this->validate($request, [
            'token' => ['required', 'string'],
        ]);

        /** @var string|null $token */
        $token = $request->get('token');

        // If the token is incorrect - redirect back to app with error
        if ($alias->forward_to_confirmation_token !== $token) {
            return response()->json([
                'error' => true,
                'message' => 'Confirmation token does not match!',
            ], 400);
        }

        $alias->update([
            'forward_to_confirmed_at' => Carbon::now(),
            'forward_to_confirmation_token' => null,
        ]);

        return new AliasResource($alias);
    }
}
