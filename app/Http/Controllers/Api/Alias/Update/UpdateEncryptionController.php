<?php

namespace App\Http\Controllers\Api\Alias\Update;

use App\Models\Alias;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alias\AliasResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class UpdateEncryptionController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return AliasResource
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function __invoke(Request $request, Alias $alias) : AliasResource
    {
        $this->authorize('owns-alias', $alias);

        $this->validate($request, [
            'pgp_key' => ['sometimes', 'nullable', 'string', 'exists:pgp_keys,uuid'],
        ]);

        // Grab the encryption key
        $key = PgpKey::where('uuid', $request->get('pgp_key'))->first();

        if (! $key instanceof PgpKey) {
            // todo - doesn't exist!!
        }

        $alias->update([
            'encryption_key_id' => $key->id,
        ]);

        return new AliasResource($alias);
    }
}
