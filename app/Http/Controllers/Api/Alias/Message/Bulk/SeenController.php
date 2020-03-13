<?php

namespace App\Http\Controllers\Api\Alias\Message\Bulk;

use App\Models\Alias;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class SeenController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function __invoke(Request $request, Alias $alias) : JsonResponse
    {
        $this->authorize('owns-alias', $alias);

        $this->validate($request, [
            'messages'   => ['required', 'array'],
            'messages.*' => ['required', 'string', 'exists:alias_messages,uuid'],
        ]);

        /** @var array $messages */
        $messages = $request->get('messages');

        /** @var Collection $models */
        $models = Message::whereIn('uuid', $messages)
            ->where('alias_id', $alias->id)
            ->update([
                'read_at' => Carbon::now(),
            ])
        ;

        return response()->json([
            'success' => true,
        ]);
    }
}
