<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebAuthMiddleware
{
    /**
     * Handle an incoming request.
     * Check if user is logged in via session.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user session exists
        if (!session()->has('user') || !session()->has('api_token')) {
            return redirect()->route('login.form')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        return $next($request);
    }
}
