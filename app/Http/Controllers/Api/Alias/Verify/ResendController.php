<?php

namespace App\Http\Controllers\Api\Alias\Verify;

use App\Models\Alias;
use App\Support\Helpers\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Support\Enums\MessageActionType;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Access\AuthorizationException;
use App\Notifications\Alias\ConfirmForwardAddressNotification;

class ResendController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias) : JsonResponse
    {
        $this->authorize('owns-alias', $alias);

        if ($alias->message_action->key === MessageActionType::FORWARD_AND_SAVE ||
            $alias->message_action->key === MessageActionType::FORWARD) {
            // Create a new token - which will cause the old one to expire
            $alias->update([
                'forward_to_confirmation_token' => Str::nanoId(),
            ]);

            Notification::route('mail', $alias->message_forward_to)
                ->notifyNow(new ConfirmForwardAddressNotification($alias->fresh()))
            ;
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
