<?php

namespace App\Http\Controllers\Web\Alias;

use Exception;
use App\Models\Alias;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Access\AuthorizationException;

class DeleteController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function __invoke(Request $request, Alias $alias)
    {
        $this->authorize('owns-alias', $alias);

        $alias->delete();

        return response()->redirectToRoute('home');
    }
}
