<?php

namespace App\Http\Controllers\Web\Frontend;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;

class FrontendController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('frontend.index');
    }

    /**
     * @return Factory|View
     */
    public function about()
    {
        return view('frontend.about');
    }

    /**
     * @return Factory|View
     */
    public function pricing()
    {
        return view('frontend.pricing');
    }
}
