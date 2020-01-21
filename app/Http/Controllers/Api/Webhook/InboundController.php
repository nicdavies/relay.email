<?php

namespace App\Http\Controllers\Api\Webhook;

use Mailgun\Mailgun;
use Illuminate\Http\Request;
use App\Jobs\InboundEmailJob;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class InboundController extends Controller
{
//    private Mailgun $mailgun;
//
//    /**
//     * InboundController constructor.
//     * @param Mailgun $mailgun
//     */
//    public function __construct(Mailgun $mailgun)
//    {
//        $this->mailgun = $mailgun;
//    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request) : JsonResponse
    {
//        $this->validate($request, [
//            '' => [],
//        ]);

        // todo - validate the incoming post data
        // todo - make sure it came from mailgun

//        $this->mailgun->webhooks()->verifyWebhookSignature(
//            $request->get('timestamp'),
//            $request->get('token'),
//            $request->get('signature')
//        );

        // Fire off a job to handle this payload so we don't keep mailgun waiting
        InboundEmailJob::dispatch($request);

        return response()->json([
            'success' => true,
        ]);
    }
}
