<?php

namespace App\Http\Controllers\Api\Group;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Group\GroupResource;
use Illuminate\Validation\ValidationException;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return GroupResource
     * @throws ValidationException
     */
    public function __invoke(Request $request) : GroupResource
    {
        /** @var User $user */
        $user = $request->user();
        $this->assert($user->subscribed(), 'Premium plan required, consider upgrading!');

        $this->validate($request, [
            'name' => ['required', 'string', 'min:2', 'max:20'],
            'description' => ['sometimes', 'nullable', 'string', 'min:3', 'max:500'],
        ]);

        /** @var Group $group */
        $group = $user
            ->groups()
            ->create([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
            ])
        ;

        return new GroupResource($group);
    }
}
