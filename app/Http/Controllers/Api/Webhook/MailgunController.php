<?php

namespace App\Http\Controllers\Api\Webhook;

use Illuminate\Http\Request;
use App\Jobs\InboundEmailJob;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class MailgunController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request) : JsonResponse
    {
        // Fire off a job to handle this payload so we don't keep mailgun waiting
        InboundEmailJob::dispatch();

        return response()->json([
            'success' => true,
        ]);
    }
}
