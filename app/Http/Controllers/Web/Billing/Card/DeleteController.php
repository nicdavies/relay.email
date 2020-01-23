<?php

namespace App\Http\Controllers\Web\Billing\Card;

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

        if (! $user->hasPaymentMethod()) {
            return response()
                ->redirectToRoute('billing')
                ->with('error', 'Welp! Looks like there\'s no payment method to remove from your account.')
            ;
        }

        $user->deletePaymentMethods();

        return response()
            ->redirectToRoute('billing')
            ->with('state', 'Removed your payment method!')
        ;
    }
}
