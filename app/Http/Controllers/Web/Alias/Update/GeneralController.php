<?php

namespace App\Http\Controllers\Web\Alias\Update;

use App\Models\Alias;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class GeneralController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function __invoke(Request $request, Alias $alias)
    {
        $this->authorize('owns-alias', $alias);

        $this->validate($request, [
            'name' => ['required', 'string', 'min:3', 'max:20'],
        ]);

        $alias->update([
            'name' => $request->get('name', $alias->name),
        ]);

        return back();
    }
}
