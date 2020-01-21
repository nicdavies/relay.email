<?php

namespace App\Http\Controllers\Web\Misc;

use App\Models\User;
use App\Models\Message;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Support\Enums\MessageActionType;

class DashboardController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|View
     */
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $aliases = $user
            ->aliases()
            ->orderByDesc('created_at')
            ->paginate(15)
        ;

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

        return view('misc.home', [
            'aliases' => $aliases,
            'total'   => [
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
