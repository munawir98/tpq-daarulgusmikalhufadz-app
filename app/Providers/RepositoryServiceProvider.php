<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// =========================
//      CONTRACTS
// =========================
use App\Repositories\Contracts\SantriRepositoryInterface;
use App\Repositories\Contracts\PengajarRepositoryInterface;
use App\Repositories\Contracts\PresensiRepositoryInterface;
use App\Repositories\Contracts\SetoranRepositoryInterface;
use App\Repositories\Contracts\InfaqRepositoryInterface;
use App\Repositories\Contracts\GajiRepositoryInterface;
use App\Repositories\Contracts\ChatPrivateRepositoryInterface;
use App\Repositories\Contracts\ChatRepositoryInterface;
use App\Repositories\Contracts\GroupRepositoryInterface;
use App\Repositories\Contracts\GroupMessageRepositoryInterface;
use App\Repositories\Contracts\KehadiranSantriRepositoryInterface;
use App\Repositories\Contracts\ProgressHafalanRepositoryInterface;
use App\Repositories\Contracts\JadwalMengajarRepositoryInterface;
use App\Repositories\Contracts\KelasRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\UstadzRepositoryInterface;

// =========================
//     ELOQUENT REPOSITORY
// =========================
use App\Repositories\Eloquent\SantriRepository;
use App\Repositories\Eloquent\PengajarRepository;
use App\Repositories\Eloquent\PresensiRepository;
use App\Repositories\Eloquent\SetoranRepository;
use App\Repositories\Eloquent\InfaqRepository;
use App\Repositories\Eloquent\GajiRepository;
use App\Repositories\Eloquent\ChatPrivateRepository;
use App\Repositories\Eloquent\ChatRepository;
use App\Repositories\Eloquent\GroupRepository;
use App\Repositories\Eloquent\GroupMessageRepository;
use App\Repositories\Eloquent\KehadiranSantriRepository;
use App\Repositories\Eloquent\ProgressHafalanRepository;
use App\Repositories\Eloquent\JadwalMengajarRepository;
use App\Repositories\Eloquent\KelasRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\UstadzRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Daftar binding interface -> repository
     */
    public array $bindings = [
        // MASTER
        SantriRepositoryInterface::class         => SantriRepository::class,
        PengajarRepositoryInterface::class       => PengajarRepository::class,

        // PRESENSI & KEHADIRAN
        PresensiRepositoryInterface::class       => PresensiRepository::class,
        KehadiranSantriRepositoryInterface::class => KehadiranSantriRepository::class,

        // PROGRESS HAFALAN
        ProgressHafalanRepositoryInterface::class => ProgressHafalanRepository::class,

        // SETORAN & KEUANGAN
        SetoranRepositoryInterface::class        => SetoranRepository::class,
        InfaqRepositoryInterface::class          => InfaqRepository::class,
        GajiRepositoryInterface::class           => GajiRepository::class,

        // CHAT
        ChatRepositoryInterface::class           => ChatRepository::class,
        ChatPrivateRepositoryInterface::class    => ChatPrivateRepository::class,

        // GROUP
        GroupRepositoryInterface::class          => GroupRepository::class,
        GroupMessageRepositoryInterface::class   => GroupMessageRepository::class,

        // JADWAL & KELAS
        JadwalMengajarRepositoryInterface::class => JadwalMengajarRepository::class,
        KelasRepositoryInterface::class          => KelasRepository::class,

        // USER & USTADZ
        UserRepositoryInterface::class           => UserRepository::class,
        UstadzRepositoryInterface::class         => UstadzRepository::class,
    ];

    /**
     * Register repository bindings.
     */
    public function register(): void
    {
        foreach ($this->bindings as $interface => $repository) {
            $this->app->bind($interface, $repository);
        }
    }

    /**
     * Boot method (disarankan untuk kompatibilitas)
     */
    public function boot(): void
    {
        //
    }
}
