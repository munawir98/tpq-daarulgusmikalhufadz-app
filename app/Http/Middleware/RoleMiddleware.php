<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        // Jika belum login
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Jika role user tidak ada di daftar role
        if (!in_array($user->role, $roles)) {
            return response()->json(['message' => 'Forbidden - Access Denied'], 403);
        }

        return $next($request);
    }
}
