<?php

namespace App\Http\Controllers\Api\Domain;

use App\Models\CustomDomain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Domain\DomainResource;
use Illuminate\Auth\Access\AuthorizationException;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @param CustomDomain $domain
     * @return DomainResource
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, CustomDomain $domain) : DomainResource
    {
        $this->authorize('owns-domain', $domain);
        return new DomainResource($domain);
    }
}
