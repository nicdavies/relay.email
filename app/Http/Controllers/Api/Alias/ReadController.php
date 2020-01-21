<?php

namespace App\Http\Controllers\Api\Alias;

use App\Models\Alias;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alias\AliasResource;
use Illuminate\Auth\Access\AuthorizationException;

class ReadController extends Controller
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
        return new AliasResource($alias);
    }
}
