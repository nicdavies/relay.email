<?php

namespace App\Http\Controllers\Api\Domain;

use App\Models\CustomDomain;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

class DeleteController extends Controller
{
    /**
     * @param Request $request
     * @param CustomDomain $domain
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, CustomDomain $domain) : JsonResponse
    {
        $this->authorize('owns-domain', $domain);

        $domain->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
