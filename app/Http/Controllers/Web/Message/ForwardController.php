<?php

namespace App\Http\Controllers\Web\Message;

use App\Models\Alias;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Access\AuthorizationException;

class ForwardController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @param Message $message
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias, Message $message) : RedirectResponse
    {
        $this->authorize('owns-alias', $alias);
        $this->authorize('owns-message', $message);

        // todo - forward this message onto the $user->email

        return back();
    }
}