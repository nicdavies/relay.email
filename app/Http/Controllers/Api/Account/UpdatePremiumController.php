<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\User;
use App\Support\Helpers\Str;
use Illuminate\Http\Request;
use App\Jobs\VerifyDomainJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Validation\ValidationException;

class UpdatePremiumController extends Controller
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
            'alias' => ['required', 'string', 'alpha_num', 'unique:users,base_alias,' . $user->id],
            'custom_domain' => ['sometimes', 'nullable', 'string', 'unique:users,custom_domain,' . $user->id],
        ]);

        if ($user->subscribed()) {
            // Check if the custom domain has changed
            $updateData = [
                'base_alias' => $request->get('alias'),
                'custom_domain' => $request->get('custom_domain'),
            ];

            // If the custom domain has changed, reset the verification
            if ($request->get('custom_domain') !== $user->custom_domain) {
                $updateData['custom_domain_verified_at'] = null;
                $updateData['custom_domain_verification_code'] = Str::nanoId();
            }

            $user->update($updateData);

            // Fire off job to validate the domain dns records
            VerifyDomainJob::dispatch($user->fresh());
        }

        return new UserResource($user);
    }
}
