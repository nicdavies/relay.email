<?php

namespace App\Http\Controllers\Web\Message;

use App\Models\Alias;
use App\Models\Message;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @param Message $message
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias, Message $message)
    {
        $this->authorize('owns-alias', $alias);
        $this->authorize('owns-message', $message);

        return view('alias.message', [
            'alias'   => $alias,
            'message' => $message,
        ]);
    }
}
