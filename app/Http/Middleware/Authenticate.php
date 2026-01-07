<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        // ✅ JIKA API / JSON → JANGAN REDIRECT KE LOGIN
        if ($request->expectsJson() || $request->is('api/*')) {
            return null;
        }

        // ❌ JANGAN PAKAI route('login')
        return null;
    }
}
