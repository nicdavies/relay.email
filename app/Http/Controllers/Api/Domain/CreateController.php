<?php

namespace App\Http\Controllers\Api\Domain;

use App\Models\User;
use App\Models\CustomDomain;
use App\Support\Helpers\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Domain\DomainResource;
use Illuminate\Validation\ValidationException;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return DomainResource
     * @throws ValidationException
     */
    public function __invoke(Request $request) : DomainResource
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->subscribed()) {
            // todo - return error?
        }

        $this->validate($request, [
            'domain' => ['required', 'string'],
        ]);

        /** @var CustomDomain $domain */
        $domain = $user
            ->customDomains()
            ->create([
                'custom_domain' => $request->get('domain'),
                'verification_code' => Str::nanoId(),
            ])
        ;

        return new DomainResource($domain);
    }
}
