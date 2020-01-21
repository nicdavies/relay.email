<?php

namespace App\Http\Controllers\Web\Misc;

use App\Models\User;
use App\Support\Enums\MessageActionType;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;

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

        return view('misc.home', [
            'aliases' => $aliases,
            'total'   => [
                'total' => $totalAliases,
                'save' => $saveAliases,
                'ignore' => $ignoreAliases,
                'forward' => $forwardAliases,
                'forwardAndSave' => $forwardAndSaveAliases,
            ],
        ]);
    }
}
