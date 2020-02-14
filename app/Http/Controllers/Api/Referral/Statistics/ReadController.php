<?php

namespace App\Http\Controllers\Api\Referral\Statistics;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReadController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        // todo - get stats of referred users
    }
}
