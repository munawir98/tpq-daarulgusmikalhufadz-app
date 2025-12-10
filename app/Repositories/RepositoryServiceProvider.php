<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

// Import all interfaces
use App\Repositories\Contracts\PresensiRepositoryInterface;
use App\Repositories\Contracts\JadwalMengajarRepositoryInterface;
use App\Repositories\Contracts\SantriRepositoryInterface;
use App\Repositories\Contracts\PengajarRepositoryInterface;
use App\Repositories\Contracts\UstadzRepositoryInterface;
use App\Repositories\Contracts\KelasRepositoryInterface;
use App\Repositories\Contracts\SetoranRepositoryInterface;
use App\Repositories\Contracts\InfaqRepositoryInterface;
use App\Repositories\Contracts\GajiRepositoryInterface;

// Import all implementations
use App\Repositories\Eloquent\PresensiRepository;
use App\Repositories\Eloquent\JadwalMengajarRepository;
use App\Repositories\Eloquent\SantriRepository;
use App\Repositories\Eloquent\PengajarRepository;
use App\Repositories\Eloquent\UstadzRepository;
use App\Repositories\Eloquent\KelasRepository;
use App\Repositories\Eloquent\SetoranRepository;
use App\Repositories\Eloquent\InfaqRepository;
use App\Repositories\Eloquent\GajiRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register()
    {
        // Presensi
        $this->app->bind(
            PresensiRepositoryInterface::class,
            PresensiRepository::class
        );

        // Jadwal Mengajar
        $this->app->bind(
            JadwalMengajarRepositoryInterface::class,
            JadwalMengajarRepository::class
        );

        // Santri
        $this->app->bind(
            SantriRepositoryInterface::class,
            SantriRepository::class
        );

        // Pengajar (optional — jika masih dipakai)
        $this->app->bind(
            PengajarRepositoryInterface::class,
            PengajarRepository::class
        );

        // Ustadz
        $this->app->bind(
            UstadzRepositoryInterface::class,
            UstadzRepository::class
        );

        // Kelas
        $this->app->bind(
            KelasRepositoryInterface::class,
            KelasRepository::class
        );

        // Setoran
        $this->app->bind(
            SetoranRepositoryInterface::class,
            SetoranRepository::class
        );

        // Infaq
        $this->app->bind(
            InfaqRepositoryInterface::class,
            InfaqRepository::class
        );

        // Gaji
        $this->app->bind(
            GajiRepositoryInterface::class,
            GajiRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
