<?php

namespace App\Http\Controllers\Web\Alias;

use App\Http\Controllers\Controller;
use App\Models\Alias;
use App\Models\User;
use App\Support\Enums\MessageActionType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|RedirectResponse|View
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('alias.create');
        }

        $this->validate($request, [
            'name'   => ['string', 'min:3', 'max:20', Rule::requiredIf(empty($request->get('alias')))],
            'alias'  => ['sometimes', 'nullable', 'string', 'alphanum', 'min:3', 'max:20'],
            'action' => ['required', 'string', new EnumValue(MessageActionType::class)],
            'forward_to' => ['sometimes', 'nullable', 'email'],
        ]);

        /** @var User $user */
        $user = $request->user();

        if ($request->has('alias') && $request->get('alias') === null) {
            $alias = hash('crc32', random_bytes(8));
        } else {
            $alias = $request->get('alias');
        }

        // The name is optional on the home page create form, so we need to create it from the alias
        if ($request->get('name') === null) {
            $name = $alias;
        } else {
            $name = $request->get('name');
        }

        /** @var Alias $alias */
        $alias = $user
            ->aliases()
            ->create([
                'name' => $name,
                'alias' => $alias,
                'message_action' => $request->get('action'),
                'message_limit'  => 500, // todo - based on the plan, decide what the message limit is!
                'message_forward_to' => $request->get('forward_to'),
            ])
        ;

        return response()->redirectToRoute('alias.show', $alias);
    }
}
