<?php

namespace App\Http\Controllers\Web\Billing;

use App\Models\User;
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
        /** @var User $user */
        $user = $request->user();

        if (! $user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        return view('billing.index', [
            'user'   => $user,
            'intent' => $user->createSetupIntent(),
        ]);
    }
}
