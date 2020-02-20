<?php

namespace App\Http\Controllers\Api\EncryptionKeys;

use Illuminate\Http\Request;
use App\Models\EncryptionKey;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

class DeleteController extends Controller
{
    /**
     * @param Request $request
     * @param EncryptionKey $key
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, EncryptionKey $key) : JsonResponse
    {
        $this->authorize('owns-encryption-key', $key);

        $key->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
