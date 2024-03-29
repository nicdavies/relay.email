<?php

namespace App\Http\Controllers\Api\Alias\Message\Render;

use App\Models\Alias;
use App\Models\Message;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use HTMLMin\HTMLMin\Facades\HTMLMin;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @param Alias $alias
     * @param Message $message
     * @return Factory|JsonResponse|View
     */
    public function __invoke(Request $request, Alias $alias, Message $message)
    {
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

        // We'll just need to reset the token so it can't be re-used
        $message->update([
            'preview_token' => null,
        ]);

        if ($message->has_html_message) {
            return view('message.html', [
                'message' => HTMLMin::html($message->body_html),
            ]);
        }

        return view('message.plain', [
            'message' => $message,
        ]);
    }
}
