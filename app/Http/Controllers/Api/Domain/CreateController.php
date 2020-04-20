<?php

namespace App\Http\Controllers\Api\Domain;

use App\Models\User;
use App\Support\Helpers\Str;
use Illuminate\Http\Request;
use App\Models\CustomDomain;
use App\Support\Rules\DomainRule;
use App\Http\Controllers\Controller;
use App\Http\Resources\Domain\DomainResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return DomainResource
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function __invoke(Request $request) : DomainResource
    {
        /** @var User $user */
        $user = $request->user();
//        $this->authorize(!$user->subscribed(), 'Premium plan required, consider upgrading!');

        $this->validate($request, [
            'domain' => ['required', 'string', new DomainRule],
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
