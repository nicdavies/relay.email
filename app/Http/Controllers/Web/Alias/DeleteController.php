<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Alias;

use App\Http\Controllers\Controller;
use App\Models\Alias;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias)
    {
        $this->authorize('owns-alias', $alias);

        $alias->delete();

        return back();
    }
}
