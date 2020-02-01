<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Validation\ValidationException;

class UpdateAliasController extends Controller
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
            'alias' => ['required', 'string', 'unique:users,base_alias'],
        ]);

        if ($user->subscribed()) {
            $user->update([
                'base_alias' => $request->get('alias'),
            ]);
        }

        return new UserResource($user);
    }
}
