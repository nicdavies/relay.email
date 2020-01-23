<?php

namespace App\Http\Controllers\Web\Alias\Update;

use Carbon\Carbon;
use App\Models\Alias;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Access\AuthorizationException;

class ForwardConfirmController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @param string $token
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias, string $token) : RedirectResponse
    {
        $this->authorize('owns-alias', $alias);

        if ($alias->forward_to_confirmation_token !== $token) {
            abort(404);
        }

        $alias->update([
            'forward_to_confirmed_at' => Carbon::now(),
            'forward_to_confirmation_token' => null,
        ]);

        return response()
            ->redirectToRoute('alias.settings', $alias)
            ->with('status', 'Forwarding Email Confirmed!')
        ;
    }
}
