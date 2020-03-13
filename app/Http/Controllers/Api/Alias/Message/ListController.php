<?php

namespace App\Http\Controllers\Api\Alias\Message;

use App\Models\User;
use App\Models\Alias;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alias\MessageResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias)
    {
        $this->authorize('owns-alias', $alias);

        /** @var User $user */
        $user = $request->user();

        // todo - limit pagination based on the history limit
        $historyLimit = $user->subscribed() ? 9999 : 50;

        $messages = $alias
            ->messages()
            ->orderByDesc('created_at')
            ->paginate(20)
        ;

        return MessageResource::collection($messages);
    }
}
