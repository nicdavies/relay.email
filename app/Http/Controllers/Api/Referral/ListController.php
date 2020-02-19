<?php

namespace App\Http\Controllers\Api\Referral;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Referral\ReferralResource;

class ListController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request) : JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $referrals = $user->referrals();

        return response()->json([
            'data' => [
                'total' => $referrals->count(),
                'referrals' => ReferralResource::collection($referrals->paginate(20)),
            ],
        ]);
    }
}
