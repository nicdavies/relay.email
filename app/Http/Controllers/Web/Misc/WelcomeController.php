<?php

namespace App\Http\Controllers\Web\Misc;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Support\Enums\MessageActionType;
use Illuminate\Validation\ValidationException;

class WelcomeController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|RedirectResponse|View
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('misc.welcome');
        }

        $this->validate($request, [
            'alias' => ['required', 'string', 'min:2', 'max:12'],
        ]);

        /** @var User $user */
        $user = $request->user();

        $user->update([
            'onboarded_at' => Carbon::now(),
        ]);

        $user
            ->aliases()
            ->create([
                'name' => $request->get('alias'),
                'alias' => $request->get('alias'),
                'message_action' => MessageActionType::SAVE,
            ])
        ;

        return response()->redirectToRoute('home');
    }
}
