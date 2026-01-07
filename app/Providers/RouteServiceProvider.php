<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        /**
         * 🔑 PENTING:
         * Matikan singularisasi otomatis pada resource parameters.
         * Wajib untuk aplikasi dengan nama resource non-Inggris
         * seperti: kelas, santri, ustadz, presensi, dll.
         */
        Route::singularResourceParameters(false);

        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
