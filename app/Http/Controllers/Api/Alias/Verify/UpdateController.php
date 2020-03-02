<?php

namespace App\Http\Controllers\Api\Alias\Verify;

use Carbon\Carbon;
use App\Models\Alias;
use Illuminate\Http\Request;
use App\Support\Helpers\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class UpdateController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Alias $alias) : RedirectResponse
    {
        /** @var string|null $token */
        $token = $request->get('token');

        $redirectUrl = sprintf(
            '%s/%s/%s/%s',
            Str::frontendUrl(),
            'aliases',
            $alias->uuid,
            'settings'
        );

        // If the token is incorrect - redirect back to app with error
        if ($alias->forward_to_confirmation_token !== $token) {
            return response()->redirectTo($redirectUrl);
        }

        $alias->update([
            'forward_to_confirmed_at' => Carbon::now(),
            'forward_to_confirmation_token' => null,
        ]);

        return response()->redirectTo($redirectUrl);
    }
}
