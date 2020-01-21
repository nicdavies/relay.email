<?php

namespace App\Http\Controllers\Web\Alias;

use App\Models\Alias;
use Illuminate\Http\Request;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Support\Enums\MessageActionType;
use Illuminate\Validation\ValidationException;

class UpdateController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request, Alias $alias) : RedirectResponse
    {
        $this->validate($request, [
            'name'   => ['required', 'string', 'min:3', 'max:20'],
            'action' => ['required', 'string', new EnumValue(MessageActionType::class)],
            'forward_to' => ['sometimes', 'nullable', 'email'],
        ]);

        $alias->update([
            'name' => $request->get('name', $alias->name),
            'message_action' => $request->get('action', $alias->message_action),
            'message_forward_to' => $request->get('forward_to', $alias->message_forward_to),
        ]);

        return back();
    }
}
