<?php

namespace App\Http\Controllers\Api\Alias\Update;

use App\Models\Alias;
use App\Support\Helpers\Str;
use Illuminate\Http\Request;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Controllers\Controller;
use App\Support\Enums\MessageActionType;
use App\Support\Rules\EmailNotRelayRule;
use App\Http\Resources\Alias\AliasResource;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use App\Notifications\Alias\ConfirmForwardAddressNotification;

class UpdateActionController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return AliasResource
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function __invoke(Request $request, Alias $alias) : AliasResource
    {
        $this->authorize('owns-alias', $alias);

        $this->validate($request, [
            'action'     => ['required', 'string', new EnumValue(MessageActionType::class)],
            'forward_to' => ['sometimes', 'nullable', 'email', new EmailNotRelayRule()],
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
                ->notify(new ConfirmForwardAddressNotification($alias, 'updated'))
            ;
        }

        $alias->update([
            'message_action' => $request->get('action', $alias->message_action->key),
        ]);

        return new AliasResource($alias);
    }
}
