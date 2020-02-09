<?php

namespace App\Http\Controllers\Api\Pgp;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pgp\PgpResource;
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

        $keys = $user
            ->pgpKeys()
            ->orderByDesc('created_at')
            ->paginate(15)
        ;

        return PgpResource::collection($keys);
    }
}
