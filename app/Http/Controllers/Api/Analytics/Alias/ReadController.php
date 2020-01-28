<?php

namespace App\Http\Controllers\Api\Analytics\Alias;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Support\Enums\MessageActionType;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request) : JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $totalAliases = $user
            ->aliases()
            ->count()
        ;

        $saveAliases = $user
            ->aliases()
            ->whereMessageAction(MessageActionType::SAVE)
            ->count()
        ;

        $ignoreAliases = $user
            ->aliases()
            ->whereMessageAction(MessageActionType::IGNORE)
            ->count()
        ;

        $forwardAliases = $user
            ->aliases()
            ->whereMessageAction(MessageActionType::FORWARD)
            ->count()
        ;

        $forwardAndSaveAliases = $user
            ->aliases()
            ->whereMessageAction(MessageActionType::FORWARD_AND_SAVE)
            ->count()
        ;

        $totalMessages = Message::whereIn('alias_id', $user->aliases()->pluck('id'))->count();

        return response()->json([
            'data' => [
                'messages' => $totalMessages,
                'total' => $totalAliases,
                'save' => $saveAliases,
                'ignore' => $ignoreAliases,
                'forward' => $forwardAliases,
                'forwardAndSave' => $forwardAndSaveAliases,
            ],
        ]);
    }
}
