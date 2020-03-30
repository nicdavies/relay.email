<?php

namespace App\Http\Controllers\Api\Alias\Message;

use App\Models\User;
use App\Models\Alias;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alias\MessageResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return AnonymousResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias)
    {
        $this->authorize('owns-alias', $alias);

        /** @var User $user */
        $user = $request->user();

        // Limit pagination based on the history limit
        $historyPageLimit = $user->subscribed() ? 99999 : 1;

        if ($request->get('page', 1) > $historyPageLimit) {
            return response()->json([
                'error' => true,
                'message' => 'Reached page limit!',
            ], 400);
        }

        $messages = $alias
            ->messages()
            ->orderByDesc('created_at')
            ->paginate(20, ['*'], 'page', $request->get('page'))
        ;

        return MessageResource::collection($messages);
    }
}
