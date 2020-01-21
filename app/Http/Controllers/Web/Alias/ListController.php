<?php

namespace App\Http\Controllers\Web\Alias;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListController extends Controller
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

        return view('alias.list', [
            'aliases' => $aliases,
        ]);
    }
}
