<?php

namespace App\Http\Controllers\Api\Pgp;

use App\Models\PgpKey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pgp\PgpResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class UpdateController extends Controller
{
    /**
     * @param Request $request
     * @param PgpKey $key
     * @return PgpResource
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function __invoke(Request $request, PgpKey $key) : PgpResource
    {
        $this->authorize('owns-pgp-key', $key);

        $this->validate($request, [

        ]);

        $key->update([

        ]);

        return new PgpResource($key);
    }
}
