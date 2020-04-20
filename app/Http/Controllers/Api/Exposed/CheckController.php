<?php

namespace App\Http\Controllers\Api\Exposed;

use App\Models\ExposedEmail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class CheckController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'sha' => ['required', 'string'],
        ]);

        /** @var ExposedEmail|null $exposedEmail */
        $exposedEmail = ExposedEmail::where('email_hash', $request->get('sha'))->first();

        if ($exposedEmail instanceof ExposedEmail) {
            return response()->json([
                'message' => 'Welp! Looks like your email address has been exposed!',
            ]);
        }

        return response()->json([
            'message' => 'Nice! It looks like your email address isn\'t exposed.',
        ]);
    }
}
