<?php

namespace App\Http\Controllers\Web\Alias;

use App\Models\Alias;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return Factory|View
     */
    public function __invoke(Request $request, Alias $alias)
    {
        return view('alias.show', [
            'alias' => $alias,
        ]);
    }
}
