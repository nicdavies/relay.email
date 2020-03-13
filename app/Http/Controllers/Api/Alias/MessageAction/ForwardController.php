<?php

namespace App\Http\Controllers\Api\Alias\MessageAction;

use App\Models\Alias;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

class ForwardController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @param Message $message
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias, Message $message) : JsonResponse
    {
        $this->authorize('owns-alias', $alias);
        $this->authorize('owns-message', $alias);

        // todo - forward the message

        return response()->json([
            'success' => true,
        ]);
    }
}
