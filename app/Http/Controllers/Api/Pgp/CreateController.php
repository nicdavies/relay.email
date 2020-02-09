<?php

namespace App\Http\Controllers\Api\Pgp;

use App\Models\User;
use App\Models\PgpKey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pgp\PgpResource;
use Illuminate\Validation\ValidationException;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return PgpResource
     * @throws ValidationException
     */
    public function __invoke(Request $request) : PgpResource
    {
        /** @var User $user */
        $user = $request->user();

        $this->validate($request, [
            'public_key' => ['required', 'string'],
            'is_default' => ['sometimes', 'nullable', 'boolean'],
        ]);

        // If this key was set as the default, grab all the other keys and set to false
        if ($request->get('is_default', false) === true) {
            $user
                ->pgpKeys()
                ->whereDefault()
                ->update([
                    'is_default' => false,
                ])
            ;
        }

        /** @var PgpKey $key */
        $key = $user
            ->pgpKeys()
            ->create([
                'public_key' => $request->get('public_key'),
                'is_default' => $request->get('is_default', false),
            ])
        ;

        return new PgpResource($key);
    }
}
