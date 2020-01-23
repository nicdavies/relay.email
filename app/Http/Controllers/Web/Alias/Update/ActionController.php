<?php

namespace App\Http\Controllers\Web\Alias\Update;

use App\Models\Alias;
use App\Support\Helpers\Str;
use Illuminate\Http\Request;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Support\Enums\MessageActionType;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use App\Notifications\Alias\ConfirmForwardAddressNotification;

class ActionController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function __invoke(Request $request, Alias $alias)
    {
        $this->authorize('owns-alias', $alias);

        $this->validate($request, [
            'action'     => ['required', 'string', new EnumValue(MessageActionType::class)],
            'forward_to' => ['sometimes', 'nullable', 'email'],
        ]);

        // Check if the forwarding address has changed, if so, send confirmation notification
        $messageForwardTo = $request->get('forward_to');

        if ($messageForwardTo !== null && $messageForwardTo !== $alias->message_forward_to) {
            $alias->update([
                'forward_to_confirmed_at' => null,
                'forward_to_confirmation_token' => Str::nanoId(),
                'message_forward_to' => $messageForwardTo,
            ]);

            Notification::route('mail', $messageForwardTo)
                ->notify(new ConfirmForwardAddressNotification($alias))
            ;
        }

        $alias->update([
            'message_action' => $request->get('action', $alias->message_action),
        ]);

        return back();
    }
}
