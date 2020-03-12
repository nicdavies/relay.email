<?php

namespace App\Http\Controllers\Api\Alias;

use App\Models\User;
use App\Models\Alias;
use App\Models\CustomDomain;
use App\Support\Helpers\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use BenSampo\Enum\Rules\EnumValue;
use App\Jobs\CreateSampleMessageJob;
use App\Http\Controllers\Controller;
use App\Support\Enums\MessageActionType;
use App\Http\Resources\Alias\AliasResource;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use App\Notifications\Alias\ConfirmForwardAddressNotification;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return AliasResource|JsonResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $this->assert($user->subscribed(), 'Premium plan required, consider upgrading!');
//        $this->assert($user->aliases()->count() >= 3, 'Premium plan required for more aliases, consider upgrading!');

        $this->validate($request, [
            'name' => ['required', 'string', 'min:2', 'max:20'],
            'alias' => ['sometimes', 'nullable', 'string', 'alphanum', 'min:2', 'max:20'],
            'action' => ['required', 'string', new EnumValue(MessageActionType::class)],
            'forward_to' => ['sometimes', 'nullable', 'email'],
            'custom_domain' => ['sometimes', 'nullable', 'exists:custom_domains,uuid'],
        ]);

        if ($request->get('alias') === null) {
            $alias = hash('crc32', random_bytes(8));
        } else {
            $alias = $request->get('alias');
        }

        // Check if the alias hasn't been used for this account before
        if ($user->aliases->pluck('alias')->contains($alias)) {
            return response()->json([
                'error' => true,
                'message' => 'You\'ve already used this alias!',
            ], 400);
        }

        // Set the message history limit based on the user's subscription
        $messageLimit = $user->subscribed() ? 999 : 50;
        $domain = null;

        if (! empty($request->get('custom_domain'))) {
            /** @var CustomDomain $customDomain */
            $customDomain = $user
                ->customDomains()
                ->where('uuid', $request->get('custom_domain'))
                ->first()
            ;

            if ($customDomain instanceof CustomDomain && $customDomain->isVerified) {
                $domain = $customDomain->id;
            }
        }

        /** @var Alias $alias */
        $alias = $user
            ->aliases()
            ->create([
                'name' => $request->get('name'),
                'alias' => $alias,
                'message_action' => $request->get('action'),
                'message_limit' => $messageLimit,
                'message_forward_to' => $request->get('forward_to'),
                'custom_domain_id' => $domain,
            ])
        ;

        // If the action is not IGNORE, then create sample message, which we will save and/or send.
        if ($alias->message_action->key !== MessageActionType::IGNORE) {
            CreateSampleMessageJob::dispatch($alias);
        }

        if ($alias->message_action->key === MessageActionType::FORWARD_AND_SAVE ||
            $alias->message_action->key === MessageActionType::FORWARD) {
            // First we just need to create the token, and then send the notification
            $alias->update([
                'forward_to_confirmation_token' => Str::nanoId(),
            ]);

            Notification::route('mail', $alias->message_forward_to)
                ->notifyNow(new ConfirmForwardAddressNotification($alias->fresh()))
            ;
        }

        return new AliasResource($alias);
    }
}
