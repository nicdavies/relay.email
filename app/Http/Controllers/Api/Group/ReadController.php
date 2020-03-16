<?php

namespace App\Http\Controllers\Api\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Group\GroupResource;
use Illuminate\Auth\Access\AuthorizationException;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @param Group $group
     * @return GroupResource
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Group $group) : GroupResource
    {
        $this->authorize('owns-group', $group);
        return new GroupResource($group);
    }
}
