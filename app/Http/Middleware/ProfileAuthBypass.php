<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileAuthBypass
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Auth::guard('profile')->check()) {
            if ($request->is(session('request-url')))
                return redirect()->route('site.index');
            return redirect()->to(session('requested-url', route('site.index')));
        }
        return $next($request);
    }
}
