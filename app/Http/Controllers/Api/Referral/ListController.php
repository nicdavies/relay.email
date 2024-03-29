<?php

namespace App\Http\Controllers\Api\Referral;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Referral\ReferralResource;
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

        $referrals = $user
            ->referredUsers()
            ->get()
        ;

        return ReferralResource::collection($referrals);
    }
}
