<?php

namespace App\Http\Controllers\Api\Pgp;

use App\Models\User;
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

        // If this is the the second-from-last key, then set the remaining key to default
        /** @var User $user */
        $user = $request->user();

        if  ($user->pgpKeys()->count() === 1) {
            $user
                ->pgpKeys()
                ->first()
                ->update([
                    'is_default' => true,
                ])
            ;
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
