<?php

namespace App\Http\Controllers\Api\EncryptionKeys;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EncryptionKey;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Resources\EncryptionKey\EncryptionKeyResource;

class UpdateController extends Controller
{
    /**
     * @param Request $request
     * @param EncryptionKey $key
     * @return EncryptionKeyResource
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function __invoke(Request $request, EncryptionKey $key) : EncryptionKeyResource
    {
        $this->authorize('owns-encryption-key', $key);

        $this->validate($request, [
            'is_default' => ['sometimes', 'boolean'],
        ]);

        /** @var User $user */
        $user = $request->user();

        // If this key is set to the default, set all others to false
        if ($request->get('is_default', false)) {
            $user
                ->encryptionKeys()
                ->whereDefault()
                ->update([
                    'is_default' => false,
                ])
            ;

            $key->update([
                'is_default' => true,
            ]);
        }

        return new EncryptionKeyResource($key);
    }
}
