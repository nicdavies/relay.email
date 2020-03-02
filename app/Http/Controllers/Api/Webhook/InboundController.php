<?php

namespace App\Http\Controllers\Api\Webhook;

use Illuminate\Http\Request;
use App\Jobs\InboundEmailJob;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class InboundController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request) : JsonResponse
    {
        // Fire off a job to handle this payload so we don't keep mailgun waiting
        InboundEmailJob::dispatch($request);

        return response()->json([
            'success' => true,
        ]);
    }
}
