<?php

namespace App\Http\Controllers\Api\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Group\GroupResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class UpdateController extends Controller
{
    /**
     * @param Request $request
     * @param Group $group
     * @return GroupResource
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function __invoke(Request $request, Group $group)
    {
        $this->authorize('owns-group', $group);

        $this->validate($request, [
            'name' => ['sometimes', 'string', 'min:2', 'max:20'],
            'description' => ['sometimes', 'nullable', 'string', 'min:2', 'max:500'],
        ]);

        $group->update([
            'name' => $request->get('name', $group->name),
            'description' => $request->get('description', $group->description),
        ]);

        return new GroupResource($group);
    }
}
