<?php

namespace App\Http\Controllers\Api\Pgp;

use App\Models\PgpKey;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

class DeleteController extends Controller
{
    /**
     * @param Request $request
     * @param PgpKey $key
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, PgpKey $key) : JsonResponse
    {
        $this->authorize('owns-pgp-key', $key);

        $key->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
