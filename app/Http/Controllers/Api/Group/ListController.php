<?php

namespace App\Http\Controllers\Api\Group;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Group\GroupResource;
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
        $this->assert($user->subscribed(), 'Premium plan required, consider upgrading!');

        $groups = $user
            ->groups()
            ->paginate(10)
        ;

        return GroupResource::collection($groups);
    }
}
