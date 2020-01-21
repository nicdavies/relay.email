<?php

namespace App\Http\Controllers\Api\Message;

use App\Models\Alias;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alias\MessageResource;
use Illuminate\Auth\Access\AuthorizationException;

class ReadController extends Controller
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
        $this->authorize('alias-message-read', $message);

        return new MessageResource($message);
    }
}
