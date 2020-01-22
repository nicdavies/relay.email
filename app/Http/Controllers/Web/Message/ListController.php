<?php

namespace App\Http\Controllers\Web\Message;

use App\Models\Alias;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Auth\Access\AuthorizationException;

class ListController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias)
    {
        $this->authorize('owns-alias', $alias);

        return view('alias.inbox', [
            'alias' => $alias,
        ]);
    }
}
