<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebRoleMiddleware
{
    /**
     * Handle an incoming request.
     * Check if user has required role.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = session('user');

        if (!$user) {
            return redirect()->route('login.form');
        }

        if (strtoupper($user['role']) !== strtoupper($role)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}
