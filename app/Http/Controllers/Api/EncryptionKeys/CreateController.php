<?php

namespace App\Http\Controllers\Api\EncryptionKeys;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EncryptionKey;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\EncryptionKey\EncryptionKeyResource;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return EncryptionKeyResource
     * @throws ValidationException
     */
    public function __invoke(Request $request) : EncryptionKeyResource
    {
        $this->validate($request, [
            'public_key' => ['required', 'string'],
        ]);

        /** @var User $user */
        $user = $request->user();

        /** @var EncryptionKey $key */
        $key = $user
            ->encryptionKeys()
            ->create([
                'public_key' => $request->get('public_key'),
            ])
        ;

        return new EncryptionKeyResource($key);
    }
}
