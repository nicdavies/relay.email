<?php

namespace App\Http\Controllers\Api\EncryptionKeys;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EncryptionKey\EncryptionKeyResource;
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
            ->encryptionKeys()
            ->orderByDesc('created_at')
            ->get()
        ;

        return EncryptionKeyResource::collection($keys);
    }
}
