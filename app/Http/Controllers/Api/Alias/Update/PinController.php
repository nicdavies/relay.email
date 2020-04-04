<?php

namespace App\Http\Controllers\Api\Alias\Update;

use App\Models\Alias;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alias\AliasResource;
use Illuminate\Auth\Access\AuthorizationException;

class PinController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return AliasResource
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias) : AliasResource
    {
        $this->authorize('owns-alias', $alias);

        if ($alias->is_pinned) {
            $isPinned = false;
        } else {
            $isPinned = true;
        }

        $alias->update([
            'is_pinned' => $isPinned,
        ]);

        return new AliasResource($alias);
    }
}
