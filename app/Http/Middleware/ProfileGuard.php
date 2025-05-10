<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!\Auth::guard('profile')->check()) {
            session()->put('requested-url', $request->fullUrl());
            return redirect()->route('profile.register');
        }
        session()->remove('requested-url');
        return $next($request);
    }
}
