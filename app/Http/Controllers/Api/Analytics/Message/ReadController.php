<?php

namespace App\Http\Controllers\Api\Analytics\Message;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

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
        $totalMessages = Message::whereIn('alias_id', $user->aliases()->pluck('id'))->count();

        $totalUnreadMessages = Message::whereIn('alias_id', $user->aliases()->pluck('id'))
            ->where('read_at', '!=', null)
            ->withoutHidden()
            ->count()
        ;

        return response()->json([
            'data' => [
                'total' => $totalMessages,
                'unread' => $totalUnreadMessages,
            ],
        ]);
    }
}
