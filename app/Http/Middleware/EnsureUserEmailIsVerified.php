<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if(!$user)
        {
            return $next($request);
        }

        if(!$user->hasVerifiedEmail())
        {
            if($request->expectsJson())
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Please verify your email address first.',
                    'email_verified' => false
                ], 403);
            }

        $routeName = $user instanceof \App\Models\Customer
                    ? 'customer.verification.notice'
                    : 'user.verification.notice';

        return redirect()->route($routeName)
                        ->with('error', 'Please verify your email address first.');
        }

        return $next($request);
    }
}
