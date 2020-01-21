<?php

namespace App\Http\Controllers\Api\Alias;

use App\Http\Resources\Alias\AliasResource;
use App\Models\Alias;
use App\Support\Enums\MessageActionType;
use BenSampo\Enum\Rules\Enum;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class UpdateController extends Controller
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
            'name'       => ['sometimes', 'string', 'min:3', 'max:20'],
            'action'     => ['sometimes', 'string', new Enum(MessageActionType::class)],
            'forward_to' => ['sometimes', 'nullable', 'email'],
        ]);

        $alias->update([
            'name' => $request->get('name', $alias->name),
            'message_action' => $request->get('message_action', $alias->message_action),
            'message_forward_to' => $request->get('message_forward_to', $alias->message_forward_to),
        ]);

        return new AliasResource($alias);
    }
}
