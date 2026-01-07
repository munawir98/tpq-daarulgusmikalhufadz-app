<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        /*
        |--------------------------------------------------------------------------
        | Middleware Aliases (Laravel 10)
        |--------------------------------------------------------------------------
        | Semua alias middleware HARUS didaftarkan di sini.
        | Kernel.php TIDAK digunakan lagi untuk alias.
        */

        $middleware->alias([
            'role'          => \App\Http\Middleware\RoleMiddleware::class,
            'token.expired' => \App\Http\Middleware\CheckTokenExpired::class,
            'web.auth'      => \App\Http\Middleware\WebAuthMiddleware::class,
            'role.web'      => \App\Http\Middleware\WebRoleMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
