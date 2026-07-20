<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if(!auth()->guard('user')->check())
        {
            return redirect()->route('user.login');
        }

            $user = auth()->guard('user')->user();

            if(!in_array($user->role, $roles))
            {
                abort(403, 'Unauthorized');
            }

        return $next($request);
    }
}
