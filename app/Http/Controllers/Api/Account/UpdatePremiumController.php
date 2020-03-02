<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Validation\ValidationException;

class UpdatePremiumController extends Controller
{
    /**
     * @param Request $request
     * @return UserResource
     * @throws ValidationException
     */
    public function __invoke(Request $request) : UserResource
    {
        /** @var User $user */
        $user = $request->user();

        $this->validate($request, [
            'alias' => ['required', 'string', 'alpha_num', 'unique:users,base_alias,' . $user->id],
        ]);

        if ($user->subscribed()) {
            $user->update([
                'base_alias' => $request->get('alias'),
            ]);
        }

        return new UserResource($user->fresh());
    }
}
