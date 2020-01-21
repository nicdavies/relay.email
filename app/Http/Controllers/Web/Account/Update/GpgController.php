<?php

namespace App\Http\Controllers\Web\Account\Update;

use App\Jobs\ReEncryptMessagesJob;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class GpgController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request) : RedirectResponse
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

        return back();
    }
}
