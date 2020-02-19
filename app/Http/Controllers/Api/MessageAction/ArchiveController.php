<?php

namespace App\Http\Controllers\Api\MessageAction;

use App\Models\Alias;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alias\MessageResource;
use Illuminate\Auth\Access\AuthorizationException;

class ArchiveController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @param Message $message
     * @return MessageResource
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias, Message $message) : MessageResource
    {
        $this->authorize('owns-alias', $alias);
        $this->authorize('owns-message', $alias);

        // Archive basically means soft-delete!
        $message->delete();

        return new MessageResource($alias);
    }
}
