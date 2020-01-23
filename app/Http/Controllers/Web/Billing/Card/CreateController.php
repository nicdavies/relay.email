<?php

namespace App\Http\Controllers\Web\Billing\Card;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'stripe_token' => ['required', 'string'],
        ]);

        /** @var User $user */
        $user = $request->user();

        $user->updateDefaultPaymentMethod($request->get('stripe_token'));

        return back();
    }
}
