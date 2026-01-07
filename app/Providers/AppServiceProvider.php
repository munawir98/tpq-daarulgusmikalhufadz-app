<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Icon;



// ===========================================
// REPOSITORY INTERFACE & IMPLEMENTATION
// ===========================================
use App\Repositories\Contracts\PresensiRepositoryInterface;
use App\Repositories\Eloquent\PresensiRepository;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;

use App\Repositories\Contracts\SantriRepositoryInterface;
use App\Repositories\Eloquent\SantriRepository;

use App\Repositories\Contracts\JadwalMengajarRepositoryInterface;
use App\Repositories\Eloquent\JadwalMengajarRepository;

use App\Repositories\Contracts\UstadzRepositoryInterface;
use App\Repositories\Eloquent\UstadzRepository;

use App\Repositories\Contracts\KelasRepositoryInterface;
use App\Repositories\Eloquent\KelasRepository;

use App\Repositories\Contracts\InfaqRepositoryInterface;
use App\Repositories\Eloquent\InfaqRepository;

use App\Repositories\Contracts\ProgressHafalanRepositoryInterface;
use App\Repositories\Eloquent\ProgressHafalanRepository;

use App\Repositories\Contracts\KehadiranSantriRepositoryInterface;
use App\Repositories\Eloquent\KehadiranSantriRepository;

use App\Repositories\Contracts\SetoranRepositoryInterface;
use App\Repositories\Eloquent\SetoranRepository;

use App\Repositories\Contracts\GajiRepositoryInterface;
use App\Repositories\Eloquent\GajiRepository;

use App\Repositories\Contracts\GroupRepositoryInterface;
use App\Repositories\Eloquent\GroupRepository;

use App\Repositories\Contracts\GroupMessageRepositoryInterface;
use App\Repositories\Eloquent\GroupMessageRepository;

use App\Repositories\Contracts\ChatRepositoryInterface;
use App\Repositories\Eloquent\ChatRepository;

use App\Repositories\Contracts\ChatPrivateRepositoryInterface;
use App\Repositories\Eloquent\ChatPrivateRepository;


// ===========================================
// SERVICE IMPORT (TAMBAH SESUAI FOLDER KA)
// ===========================================
use App\Services\Presensi\PresensiService;
use App\Services\Notification\FcmService;
use App\Services\Auth\AuthService;
use App\Services\Chat\ChatService;
use App\Services\Group\GroupService;
use App\Services\Santri\SantriService;
use App\Services\Pengajar\PengajarService;
use App\Services\Jadwal\JadwalService;
use App\Services\Kelas\KelasService;
use App\Services\Infaq\InfaqService;
use App\Services\Gaji\GajiService;
use App\Services\Setoran\SetoranService;
use App\Services\Hafalan\ProgressHafalanService;
use App\Services\Kehadiran\KehadiranSantriService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // =====================================================
        // BINDING REPOSITORY
        // =====================================================
        $this->app->bind(PresensiRepositoryInterface::class, PresensiRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(SantriRepositoryInterface::class, SantriRepository::class);
        $this->app->bind(UstadzRepositoryInterface::class, UstadzRepository::class);
        $this->app->bind(JadwalMengajarRepositoryInterface::class, JadwalMengajarRepository::class);
        $this->app->bind(KelasRepositoryInterface::class, KelasRepository::class);
        $this->app->bind(InfaqRepositoryInterface::class, InfaqRepository::class);
        $this->app->bind(GajiRepositoryInterface::class, GajiRepository::class);
        $this->app->bind(SetoranRepositoryInterface::class, SetoranRepository::class);
        $this->app->bind(ProgressHafalanRepositoryInterface::class, ProgressHafalanRepository::class);
        $this->app->bind(KehadiranSantriRepositoryInterface::class, KehadiranSantriRepository::class);
        $this->app->bind(ChatRepositoryInterface::class, ChatRepository::class);
        $this->app->bind(ChatPrivateRepositoryInterface::class, ChatPrivateRepository::class);
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
        $this->app->bind(GroupMessageRepositoryInterface::class, GroupMessageRepository::class);

        // =====================================================
        // BINDING SERVICE
        // =====================================================
        $this->app->bind(PresensiService::class, PresensiService::class);
        $this->app->bind(FcmService::class, FcmService::class);
        $this->app->bind(AuthService::class, AuthService::class);
        $this->app->bind(ChatService::class, ChatService::class);
        $this->app->bind(GroupService::class, GroupService::class);
        $this->app->bind(SantriService::class, SantriService::class);
        $this->app->bind(PengajarService::class, PengajarService::class);
        $this->app->bind(JadwalService::class, JadwalService::class);
        $this->app->bind(KelasService::class, KelasService::class);
        $this->app->bind(InfaqService::class, InfaqService::class);
        $this->app->bind(GajiService::class, GajiService::class);
        $this->app->bind(SetoranService::class, SetoranService::class);
        $this->app->bind(ProgressHafalanService::class, ProgressHafalanService::class);
        $this->app->bind(KehadiranSantriService::class, KehadiranSantriService::class);
    }

    public function boot(): void
    {
        Blade::component('icon', Icon::class);

        // Force HTTPS in production (Railway uses HTTPS)
        if (config('app.env') === 'production' || app()->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }

}
