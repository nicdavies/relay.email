<?php

namespace App\Http\Controllers\Api\Domain\Verify;

use App\Models\CustomDomain;
use Illuminate\Http\Request;
use App\Jobs\VerifyDomainJob;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

class UpdateController extends Controller
{
    /**
     * @param Request $request
     * @param CustomDomain $domain
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, CustomDomain $domain)
    {
        $this->authorize('owns-domain', $domain);

//        VerifyDomainJob::dispatchUnless($domain->isVerified, $domain);
        VerifyDomainJob::dispatchNow($domain);

        return response()->json([
            'success' => true,
        ]);
    }
}
