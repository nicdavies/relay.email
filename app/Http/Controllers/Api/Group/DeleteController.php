<?php

namespace App\Http\Controllers\Api\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

class DeleteController extends Controller
{
    /**
     * @param Request $request
     * @param Group $group
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Group $group) : JsonResponse
    {
        $this->authorize('owns-group', $group);

        $group->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
