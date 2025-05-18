<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user()->role;

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $userRoleName = $user->name ;

        if (!$userRoleName || !in_array(strtolower($userRoleName), array_map('strtolower', $roles))) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
