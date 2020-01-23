<?php

namespace App\Http\Controllers\Web\Alias;

use App\Models\Alias;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Auth\Access\AuthorizationException;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias)
    {
        $this->authorize('owns-alias', $alias);

        $activity = Activity::where('subject_id', $alias->id)
            ->where('subject_type', Alias::class)
            ->orderByDesc('created_at')
            ->paginate(15)
        ;

        return view('alias.show', [
            'alias' => $alias,
            'activity' => $activity,
        ]);
    }
}
