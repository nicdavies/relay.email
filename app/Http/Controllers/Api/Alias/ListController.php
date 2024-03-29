<?php

namespace App\Http\Controllers\Api\Alias;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alias\AliasResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $aliases = $user
            ->aliases()
            ->orderByDesc('created_at')
        ;

        if ((bool)$request->get('pinned', false)) {
            $aliases = $aliases->wherePinned();
        }

        $aliases = $aliases->get();

        return AliasResource::collection($aliases);
    }
}
