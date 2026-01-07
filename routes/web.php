<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WEB CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\SantriWebController;
use App\Http\Controllers\Web\KelasWebController;
use App\Http\Controllers\Web\PresensiWebController;
use App\Http\Controllers\Web\ProfileWebController;
use App\Http\Controllers\Web\NotificationWebController;
use App\Http\Controllers\Web\ChatWebController;
use App\Http\Controllers\Web\HafalanWebController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthWebController::class, 'showLoginForm'])
        ->name('login.form');

    Route::post('/login', [AuthWebController::class, 'login'])
        ->name('login');

    Route::get('/register', [AuthWebController::class, 'showRegisterForm'])
        ->name('register.form');

    Route::post('/register', [AuthWebController::class, 'register'])
        ->name('register');

    Route::get('/forgot-password', [AuthWebController::class, 'showForgotPasswordForm'])
        ->name('password.request');

    Route::post('/forgot-password', [AuthWebController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('/verify-otp', [AuthWebController::class, 'showVerifyOtpForm'])
        ->name('password.verify');

    Route::post('/verify-otp', [AuthWebController::class, 'verifyOtp'])
        ->name('password.verify.submit');

    Route::get('/reset-password', [AuthWebController::class, 'showResetPasswordForm'])
        ->name('password.reset');

    Route::post('/reset-password', [AuthWebController::class, 'resetPassword'])
        ->name('password.update');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED WEB
|--------------------------------------------------------------------------
*/
Route::middleware('web.auth')->group(function () {

    Route::match(['get', 'post'], '/logout', [AuthWebController::class, 'logout'])
        ->name('logout');

    /**
     * AUTO DASHBOARD (REDIRECT SESUAI ROLE)
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileWebController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileWebController::class, 'edit'])->name('edit');
        Route::post('/update', [ProfileWebController::class, 'update'])->name('update');
        Route::get('/password', [ProfileWebController::class, 'showPasswordForm'])->name('password');
        Route::post('/password', [ProfileWebController::class, 'changePassword'])->name('password.update');
        Route::post('/upload-photo', [ProfileWebController::class, 'uploadPhoto'])->name('photo');
        Route::delete('/delete-photo', [ProfileWebController::class, 'deletePhoto'])->name('photo.delete');

        // Notifications
        Route::get('/notifications', [ProfileWebController::class, 'notifications'])->name('notifications');
        Route::post('/notifications/{id}/read', [ProfileWebController::class, 'markNotificationRead'])->name('notifications.read');
        Route::post('/notifications/mark-all-read', [ProfileWebController::class, 'markAllNotificationsRead'])->name('notifications.markAllRead');
    });

    /*
    |--------------------------------------------------------------------------
    | NOTIFICATIONS
    |--------------------------------------------------------------------------
    */
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationWebController::class, 'index'])->name('index');
        Route::post('/mark-all-read', [NotificationWebController::class, 'markAllRead'])->name('markAllRead');
        Route::post('/{id}/read', [NotificationWebController::class, 'markAsRead'])->name('read');
        Route::delete('/{id}', [NotificationWebController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | CHAT
    |--------------------------------------------------------------------------
    */
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [ChatWebController::class, 'index'])->name('index');
        Route::get('/new', [ChatWebController::class, 'create'])->name('new');
        Route::get('/{id}', [ChatWebController::class, 'room'])->name('room');
        Route::post('/{id}/send', [ChatWebController::class, 'send'])->name('send');
    });

    /*
    |--------------------------------------------------------------------------
    | HELPER PAGES
    |--------------------------------------------------------------------------
    */
    Route::get('/help', fn () => view('pages.help'))->name('help');
    Route::get('/about', fn () => view('pages.about'))->name('about');

    /*
    |--------------------------------------------------------------------------
    | SANTRI DATA
    |--------------------------------------------------------------------------
    */
    Route::prefix('santri-data')->group(function () {
        Route::get('/', [SantriWebController::class, 'index'])->name('santri.index');
        Route::get('/{id}', [SantriWebController::class, 'show'])->name('santri.show');
    });

    /*
    |--------------------------------------------------------------------------
    | KELAS
    |--------------------------------------------------------------------------
    */
    Route::prefix('kelas')->group(function () {
        Route::get('/', [KelasWebController::class, 'index'])->name('kelas.index');
        Route::get('/{id}', [KelasWebController::class, 'show'])->name('kelas.show');
        Route::get('/{id}/presensi', [KelasWebController::class, 'rekapPresensi'])->name('kelas.presensi');
    });

    /*
    |--------------------------------------------------------------------------
    | PRESENSI (SHARED)
    |--------------------------------------------------------------------------
    */
    Route::prefix('presensi')->group(function () {
        Route::get('/', [PresensiWebController::class, 'index'])->name('presensi.index');
        Route::post('/masuk', [PresensiWebController::class, 'masuk'])->name('presensi.masuk');
        Route::post('/pulang', [PresensiWebController::class, 'pulang'])->name('presensi.pulang');
    });
});

/*
|--------------------------------------------------------------------------
| ROLE BASED ROUTES
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['web.auth', 'role.web:ADMIN'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin'])
            ->name('dashboard');

        Route::get('/activity-logs', fn () => view('admin.activity.index'))
            ->name('activity');

        // Santri Management
        Route::prefix('santri')->name('santri.')->group(function () {
            Route::get('/', [SantriWebController::class, 'adminIndex'])->name('index');
            Route::get('/create', [SantriWebController::class, 'create'])->name('create');
            Route::post('/', [SantriWebController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [SantriWebController::class, 'edit'])->name('edit');
            Route::put('/{id}', [SantriWebController::class, 'update'])->name('update');
            Route::delete('/{id}', [SantriWebController::class, 'destroy'])->name('destroy');
        });

        // Ustadz Management
        Route::prefix('ustadz')->name('ustadz.')->group(function () {
            Route::get('/', fn () => view('admin.ustadz.index'))->name('index');
        });

        // Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', fn () => view('admin.settings.index'))->name('index');
            Route::get('/profile', fn () => view('admin.settings.profile'))->name('profile');
            Route::post('/profile/update', [ProfileWebController::class, 'update'])->name('profile.update');
            Route::post('/profile/upload-photo', [ProfileWebController::class, 'uploadPhoto'])->name('profile.photo');
            Route::get('/password', fn () => view('admin.settings.password'))->name('password');
            Route::post('/password', [ProfileWebController::class, 'updatePassword'])->name('password.update');
        });
    });

/*
|--------------------------------------------------------------------------
| USTADZ
|--------------------------------------------------------------------------
*/
Route::middleware(['web.auth', 'role.web:USTADZ'])
    ->prefix('ustadz')
    ->name('ustadz.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'ustadz'])
            ->name('dashboard');

        Route::get('/kelas', fn () => view('ustadz.kelas'))
            ->name('kelas');

        Route::get('/menu', fn () => view('ustadz.menu'))
            ->name('menu');

        Route::get('/presensi', [PresensiWebController::class, 'ustadzIndex'])
            ->name('presensi');

        // Hafalan / Setoran
        Route::prefix('hafalan')->name('hafalan.')->group(function () {
            Route::get('/', [HafalanWebController::class, 'index'])->name('index');
            Route::get('/input', [HafalanWebController::class, 'inputForm'])->name('input');
            Route::get('/create', [HafalanWebController::class, 'create'])->name('create');
            Route::post('/', [HafalanWebController::class, 'store'])->name('store');
            Route::get('/last/{santriId}', [HafalanWebController::class, 'getLastHafalan'])->name('last');
            Route::get('/{id}/edit', [HafalanWebController::class, 'edit'])->name('edit');
            Route::put('/{id}', [HafalanWebController::class, 'update'])->name('update');
            Route::get('/{id}', [HafalanWebController::class, 'show'])->name('show');
        });

        // Laporan Hafalan
        Route::get('/laporan', [HafalanWebController::class, 'laporan'])->name('laporan');

        // Nilai
        Route::prefix('nilai')->name('nilai.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Web\NilaiWebController::class, 'index'])->name('index');
            Route::get('/hafalan', [\App\Http\Controllers\Web\NilaiWebController::class, 'hafalan'])->name('hafalan');
            Route::get('/tajwid', [\App\Http\Controllers\Web\NilaiWebController::class, 'tajwid'])->name('tajwid');
            Route::post('/tajwid', [\App\Http\Controllers\Web\NilaiWebController::class, 'storeTajwid'])->name('tajwid.store');
            Route::get('/akhlak', [\App\Http\Controllers\Web\NilaiWebController::class, 'akhlak'])->name('akhlak');
            Route::post('/akhlak', [\App\Http\Controllers\Web\NilaiWebController::class, 'storeAkhlak'])->name('akhlak.store');
            Route::get('/rapor', [\App\Http\Controllers\Web\NilaiWebController::class, 'rapor'])->name('rapor');
        });

        // Settings
        Route::get('/settings', fn () => view('ustadz.settings.index'))->name('settings');
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/profile', fn () => view('ustadz.settings.profile'))->name('profile');
            Route::post('/profile/update', [ProfileWebController::class, 'update'])->name('profile.update');
            Route::post('/profile/upload-photo', [ProfileWebController::class, 'uploadPhoto'])->name('profile.photo');
            Route::get('/password', fn () => view('ustadz.settings.password'))->name('password');
            Route::post('/password', [ProfileWebController::class, 'updatePassword'])->name('password.update');
        });

        // Broadcast / Pengumuman
        Route::prefix('broadcast')->name('broadcast.')->group(function () {
            Route::get('/create', [\App\Http\Controllers\Web\BroadcastController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Web\BroadcastController::class, 'store'])->name('store');
            Route::get('/', [\App\Http\Controllers\Web\BroadcastController::class, 'index'])->name('index');
        });
    });

/*
|--------------------------------------------------------------------------
| SANTRI
|--------------------------------------------------------------------------
*/
Route::middleware(['web.auth', 'role.web:SANTRI'])
    ->prefix('santri')
    ->name('santri.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'santri'])
            ->name('dashboard');

        Route::get('/progress', fn () => view('santri.progress'))
            ->name('progress');

        // Presensi
        Route::prefix('presensi')->name('presensi.')->group(function () {
            Route::get('/', [PresensiWebController::class, 'santriIndex'])->name('index');
            Route::post('/', [PresensiWebController::class, 'santriStore'])->name('store');
            Route::get('/history', [PresensiWebController::class, 'santriHistory'])->name('history');
        });

        // Jadwal
        Route::get('/jadwal', fn () => view('santri.jadwal'))->name('jadwal');

        // Riwayat Hafalan
        Route::get('/hafalan', [DashboardController::class, 'hafalanHistory'])->name('hafalan.index');
    });

