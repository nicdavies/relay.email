<?php

namespace App\Http\Controllers\Web\Billing\Subscription;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class DeleteController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function __invoke(Request $request) : RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->subscribed()) {
            return response()
                ->redirectToRoute('billing')
                ->with('error', 'No active subscription to cancel!')
            ;
        }

        $user
            ->subscription('default')
            ->cancel()
        ;

        return response()
            ->redirectToRoute('billing')
            ->with('state', 'Cancelled your subscription!')
        ;
    }
}
