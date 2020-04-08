<?php

namespace App\Http\Controllers\Api\Alias\Message\Render;

use App\Models\Alias;
use App\Models\Message;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Auth\Access\AuthorizationException;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @param Message $message
     * @return Factory|JsonResponse|View
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Alias $alias, Message $message)
    {
//        $this->authorize('owns-alias', $alias);
//        $this->authorize('owns-message', $message);

        /** @var string|null $previewToken */
        $previewToken = $request->get('token');

        if (empty($previewToken)) {
            return response()->json([
                'error'   => true,
                'message' => 'Invalid preview token!',
            ], 403);
        }

        if ($previewToken !== $message->preview_token) {
            return response()->json([
                'error'   => true,
                'message' => 'Invalid preview token!',
            ], 403);
        }

        if ($message->has_html_message) {
            return view('message.html', [
                'message' => $message,
            ]);
        }

        return view('message.plain', [
            'message' => $message,
        ]);
    }
}
