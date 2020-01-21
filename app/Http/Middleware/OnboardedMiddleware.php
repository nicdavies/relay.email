<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class OnboardedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isOnboarded) {
            return response()->redirectToRoute('welcome');
        }

        return $next($request);
    }
}
