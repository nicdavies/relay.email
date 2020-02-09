<?php

namespace App\Http\Controllers\Api\Pgp;

use App\Models\PgpKey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pgp\PgpResource;
use Illuminate\Auth\Access\AuthorizationException;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @param PgpKey $key
     * @return PgpResource
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, PgpKey $key) : PgpResource
    {
        $this->authorize('owns-pgp-key', $key);
        return new PgpResource($key);
    }
}
