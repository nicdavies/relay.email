<?php

namespace App\Http\Controllers\Web\Account;

use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\ReEncryptMessagesJob;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class UpdateGpgController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request) : RedirectResponse
    {
        $this->validate($request, [
            'gpg_public_key' => ['required', 'nullable', 'string'],
        ]);

        /** @var User $user */
        $user = $request->user();

        // If the value has changed we need to set the current key in the old property
        if ($request->get('gpg_public_key') !== $user->gpg_public_key) {
            $user->update([
                'gpg_public_key'     => $request->get('gpg_public_key'),
                'old_gpg_public_key' => $user->gpg_public_key,
            ]);

            // We now need to re-encrypt all the old messages that were using the old key
            ReEncryptMessagesJob::dispatch();
        }

        return back();
    }
}
