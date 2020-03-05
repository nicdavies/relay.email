<?php

namespace App\Http\Controllers\Api\Domain;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Domain\DomainResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $domains = $user
            ->customDomains()
            ->get()
        ;

        return DomainResource::collection($domains);
    }
}
