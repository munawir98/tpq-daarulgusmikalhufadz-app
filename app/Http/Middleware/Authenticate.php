<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Token tidak valid atau tidak dikirim.'
            ], 401);
        }
    }
}
