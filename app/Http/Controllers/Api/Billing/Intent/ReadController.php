<?php

namespace App\Http\Controllers\Api\Billing\Intent;

use App\Models\User;
use Stripe\SetupIntent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @return SetupIntent
     */
    public function __invoke(Request $request) : SetupIntent
    {
        /** @var User $user */
        $user = $request->user();
        return $user->createSetupIntent();
    }
}
