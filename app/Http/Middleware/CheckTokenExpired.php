<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\ApiResponse;

class CheckTokenExpired
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->user()?->currentAccessToken();

        if (! $token) {
            return ApiResponse::error('Token tidak valid', 401);
        }

        if ($token->expires_at && Carbon::now()->greaterThan($token->expires_at)) {
            $token->delete();

            return ApiResponse::error(
                'Token sudah kedaluwarsa, silakan login ulang',
                401
            );
        }

        return $next($request);
    }
}
