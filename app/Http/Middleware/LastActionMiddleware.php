<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class LastActionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user instanceof User) {
            return $next($request);
        }

        $user->update([
            'last_action_at' => Carbon::now(),
        ]);

        return $next($request);
    }
}
