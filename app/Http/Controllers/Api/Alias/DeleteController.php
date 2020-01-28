<?php

namespace App\Http\Controllers\Api\Alias;

use App\Models\Alias;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

class DeleteController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias) : JsonResponse
    {
        $this->authorize('owns-alias', $alias);

        $alias->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
