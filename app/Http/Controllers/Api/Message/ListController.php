<?php

namespace App\Http\Controllers\Api\Message;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alias\MessageResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $messages = $user
            ->messages()
            ->withoutHidden()
            ->orderByDesc('created_at')
            ->paginate(20)
        ;

        return MessageResource::collection($messages);
    }
}
