<?php

namespace App\Http\Controllers\Api\Message\Bulk;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class ArchiveController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'messages'   => ['required', 'array'],
            'messages.*' => ['required', 'string', 'exists:alias_messages,uuid'],
        ]);

        /** @var User $user */
        $user = $request->user();

        /** @var Collection $aliasIds */
        $aliasIds = $user
            ->aliases()
            ->pluck('id')
        ;

        /** @var array $messages */
        $messages = $request->get('messages');

        /** @var Collection $models */
        $models = Message::whereIn('uuid', $messages)
            ->whereIn('alias_id', $aliasIds)
            ->get()
        ;

        // todo - archive the messages!

        return response()->json([
            'success' => true,
        ]);
    }
}
