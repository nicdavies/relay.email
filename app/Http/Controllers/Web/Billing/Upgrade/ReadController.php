<?php

namespace App\Http\Controllers\Web\Billing\Upgrade;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|View
     */
    public function __invoke(Request $request)
    {
        return view('billing.upgrade', [
            'user' => $request->user(),
        ]);
    }
}
