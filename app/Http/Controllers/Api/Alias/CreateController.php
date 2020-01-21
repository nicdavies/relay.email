<?php

namespace App\Http\Controllers\Api\Alias;

use App\Models\User;
use App\Models\Alias;
use Illuminate\Http\Request;
use BenSampo\Enum\Rules\Enum;
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
        $this->validate($request, [
            'name'   => ['required', 'string', 'min:3', 'max:20'],
            'alias'  => ['sometimes', 'nullable', 'string', 'min:3', 'max:20'],
            'action' => ['required', 'string', new Enum(MessageActionType::class)],
            'forward_to' => ['sometimes', 'nullable', 'email'],
        ]);

        /** @var User $user */
        $user = $request->user();

        /** @var Alias $alias */
        $alias = $user
            ->aliases()
            ->create([
                'name' => $request->get('name'),
                'alias' => $request->get('alias'),
                'message_action' => $request->get('action'),
                'message_forward_to' => $request->get('forward_to'),
            ])
        ;

        return new AliasResource($alias);
    }
}
