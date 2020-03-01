<?php

namespace App\Http\Controllers\Api\Alias;

use App\Models\User;
use App\Models\Alias;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use BenSampo\Enum\Rules\EnumValue;
use App\Jobs\CreateSampleMessageJob;
use App\Http\Controllers\Controller;
use App\Support\Enums\MessageActionType;
use App\Http\Resources\Alias\AliasResource;
use Illuminate\Validation\ValidationException;

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

        // If the user user is on not on premium check they haven't gone over the 3 alias limit
        if (! $user->subscribed() && $user->aliases()->count() >= 3) {
            return response()->json([
                'error' => true,
                'message' => 'Premium plan required for more aliases, consider upgrading!',
            ], 402);
        }

        $this->validate($request, [
            'name' => ['required', 'string', 'min:3', 'max:20'],
            'alias' => ['sometimes', 'nullable', 'string', 'alphanum', 'min:3', 'max:20'],
            'action' => ['required', 'string', new EnumValue(MessageActionType::class)],
            'forward_to' => ['sometimes', 'nullable', 'email'],
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

        // Set the message limit based on the user's subscription
        $messageLimit = $user->subscribed() ? 500 : 50;

        /** @var Alias $alias */
        $alias = $user
            ->aliases()
            ->create([
                'name' => $request->get('name'),
                'alias' => $alias,
                'message_action' => $request->get('action'),
                'message_limit' => $messageLimit,
                'message_forward_to' => $request->get('forward_to'),
            ])
        ;

        // If the action is not IGNORE, then create sample message, which we will save and/or send.
        if ($alias->message_action !== MessageActionType::IGNORE) {
            CreateSampleMessageJob::dispatch($alias);
        }

        return new AliasResource($alias);
    }
}
