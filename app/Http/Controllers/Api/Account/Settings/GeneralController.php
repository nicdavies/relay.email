<?php

namespace App\Http\Controllers\Api\Account\Settings;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\EmailNotRelayRule;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Validation\ValidationException;

class GeneralController extends Controller
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
            'name'  => ['sometimes', 'string', 'min:3', 'max:20'],
            'email' => ['sometimes', 'email', 'unique:users,email,' . $user->id, new EmailNotRelayRule],
        ]);

        $user->update([
            'name' => $request->get('name', $user->name),
            'email' => $request->get('email', $user->email),
        ]);

        $user->refresh();

        return new UserResource($user);
    }
}
