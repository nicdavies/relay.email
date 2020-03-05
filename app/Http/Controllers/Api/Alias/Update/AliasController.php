<?php

namespace App\Http\Controllers\Api\Alias\Update;

use App\Models\User;
use App\Models\Alias;
use App\Models\CustomDomain;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alias\AliasResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class AliasController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return AliasResource|JsonResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function __invoke(Request $request, Alias $alias)
    {
        $this->authorize('owns-alias', $alias);

        $this->validate($request, [
            'custom_domain' => ['sometimes', 'nullable', 'exists:custom_domains,uuid'],
        ]);

        /** @var User $user */
        $user = $request->user();

        /** @var CustomDomain $domain */
        $domain = $user
            ->customDomains()
            ->where('uuid', $request->get('custom_domain'))
            ->first()
        ;

        if (! $domain instanceof CustomDomain) {
            return response()->json([
                'error' => true,
                'message' => 'No domain found!',
            ], 400);
        }

        // If domain is not verified, return error!
        if (! $domain->isVerified) {
            return response()->json([
                'error' => true,
                'message' => 'Domain must be verified first!',
            ], 400);
        }

        $alias->update([
            'custom_domain' => $domain->id,
        ]);

        return new AliasResource($alias);
    }
}
