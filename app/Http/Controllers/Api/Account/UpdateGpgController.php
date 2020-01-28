<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\ReEncryptMessagesJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Validation\ValidationException;

class UpdateGpgController extends Controller
{
    /**
     * @param Request $request
     * @return UserResource
     * @throws ValidationException
     */
    public function __invoke(Request $request) : UserResource
    {
        /** @var User $user */
        $user = $request->user();

        $this->validate($request, [
            'gpg_key' => ['required', 'string'],
        ]);

        // Get the current key
        $oldKey = $user->currentGpgKey;
        $newKey = $request->get('gpg_key');

        $user
            ->gpgKeys()
            ->create([
                'gpg_key' => $newKey,
            ])
        ;

        // Dispatch a job to re-encrypt messages using the new key
        ReEncryptMessagesJob::dispatch($user, $oldKey, $newKey);

        return new UserResource($user);
    }
}
