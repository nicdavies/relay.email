<?php

namespace App\Http\Controllers\Api\Billing;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Billing\SubscriptionResource;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @return SubscriptionResource
     */
    public function __invoke(Request $request) : SubscriptionResource
    {
        /** @var User $user */
        $user = $request->user();
        return new SubscriptionResource($user);
    }
}
