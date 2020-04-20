<?php

namespace App\Http\Controllers\Api\Domain\Verify;

use App\Models\CustomDomain;
use Illuminate\Http\Request;
use App\Jobs\VerifyDomainJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\Domain\DomainResource;
use Illuminate\Auth\Access\AuthorizationException;

class UpdateController extends Controller
{
    /**
     * @param Request $request
     * @param CustomDomain $domain
     * @return DomainResource
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, CustomDomain $domain)
    {
        $this->authorize('owns-domain', $domain);

//        VerifyDomainJob::dispatchUnless($domain->isVerified, $domain);
        VerifyDomainJob::dispatchNow($domain);

        return new DomainResource($domain);
    }
}
