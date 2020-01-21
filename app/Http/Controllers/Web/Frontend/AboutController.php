<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|View
     */
    public function __invoke(Request $request)
    {
        return view('frontend.index');
    }
}
