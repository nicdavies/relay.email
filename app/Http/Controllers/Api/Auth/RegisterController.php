<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Events\RegisterEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserResource;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * @param Request $request
     * @return UserResource
     * @throws ValidationException
     */
    public function __invoke(Request $request) : UserResource
    {
        $this->validate($request, [
            'name'              => ['required', 'string', 'min:3', 'max:20'],
            'email'             => ['required', 'email', 'unique:users,email'],
            'password'          => ['required', 'string', 'min:6', 'max:100'],
            'confirm_password'  => ['required', 'string', 'same:password'],
        ]);

        /** @var User $user */
        $user = User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'base_alias' => hash('crc32', random_bytes(8)),
        ]);

        event(new RegisterEvent($request, $user));

        return new UserResource($user);
    }
}