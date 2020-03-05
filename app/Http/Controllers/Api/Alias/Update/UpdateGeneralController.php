<?php

namespace App\Http\Controllers\Api\Alias\Update;

use App\Models\Alias;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alias\AliasResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class UpdateGeneralController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return AliasResource
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function __invoke(Request $request, Alias $alias) : AliasResource
    {
        $this->authorize('owns-alias', $alias);

        $this->validate($request, [
            'name' => ['required', 'string', 'min:3', 'max:20'],
            'description' => ['sometimes', 'nullable', 'max:500'],
        ]);

        $alias->update([
            'name' => $request->get('name', $alias->name),
            'description' => $request->get('description', $alias->description),
        ]);

        return new AliasResource($alias);
    }
}
