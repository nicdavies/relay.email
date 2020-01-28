<?php

namespace App\Http\Controllers\Api\Alias;

use App\Models\User;
use App\Models\Alias;
use Illuminate\Http\Request;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Controllers\Controller;
use App\Support\Enums\MessageActionType;
use App\Http\Resources\Alias\AliasResource;
use Illuminate\Validation\ValidationException;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return AliasResource
     * @throws ValidationException
     */
    public function __invoke(Request $request) : AliasResource
    {
        /** @var User $user */
        $user = $request->user();

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

        // todo - check if the alias hasn't been used for this account before

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

        return new AliasResource($alias);
    }
}
