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
            'is_default' => ['sometimes', 'boolean'],
        ]);

        /** @var User $user */
        $user = $request->user();

        // If this new key is the default, we need to toggle all the others to false
        if ($request->get('is_default', false)) {
            $user
                ->encryptionKeys()
                ->whereDefault()
                ->update([
                    'is_default' => false,
                ])
            ;
        }

        /** @var EncryptionKey $key */
        $key = $user
            ->encryptionKeys()
            ->create([
                'public_key' => $request->get('public_key'),
                'is_default' => $request->get('is_default', false),
            ])
        ;

        return new EncryptionKeyResource($key);
    }
}
