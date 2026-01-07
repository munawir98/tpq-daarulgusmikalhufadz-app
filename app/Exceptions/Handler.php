<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Handle unauthenticated users.
     */
    protected function unauthenticated(
        $request,
        AuthenticationException $exception
    ) {
        // ✅ API / JSON REQUEST
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        // ❌ JANGAN redirect ke route login
        abort(401);
    }
}
