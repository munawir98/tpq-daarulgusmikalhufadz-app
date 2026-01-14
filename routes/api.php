<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLER IMPORTS
|--------------------------------------------------------------------------
*/

// AUTH
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SantriAuthController;

// DASHBOARD
use App\Http\Controllers\Api\DashboardController;

// MASTER DATA
use App\Http\Controllers\Api\SantriController;
use App\Http\Controllers\Api\SantriTemplateController;
use App\Http\Controllers\Api\PengajarController;
use App\Http\Controllers\Api\UstadzController;
use App\Http\Controllers\Api\JadwalMengajarController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\SantriImportController;

// SETORAN & INFAQ
use App\Http\Controllers\Api\SetoranController;
use App\Http\Controllers\Api\InfaqController;

// GAJI
use App\Http\Controllers\Api\GajiController;
use App\Http\Controllers\Api\GajiPengajarRekapController;

// PRESENSI
use App\Http\Controllers\Api\PresensiController;

// CHAT
use App\Http\Controllers\Api\ChatPrivateController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\GroupMessageController;

// AKHLAK & NILAI
use App\Http\Controllers\Api\AkhlakSantriController;
use App\Http\Controllers\Api\NilaiUjianController;

// ACTIVITY LOG
use App\Http\Controllers\Api\ActivityLogController;

// FCM
use App\Http\Controllers\Api\FcmTokenController;

/*
|--------------------------------------------------------------------------
| PUBLIC AUTH (TANPA TOKEN)
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/santri/login', [SantriAuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| REFRESH TOKEN (BUTUH TOKEN, TANPA token.expired)
|--------------------------------------------------------------------------
*/
Route::post('/refresh-token', [AuthController::class, 'refreshToken'])
    ->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| PUBLIC DATA (TANPA AUTH)
|--------------------------------------------------------------------------
*/
Route::get('/kelas-public', [KelasController::class, 'index']);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (SANCTUM ONLY — TEST MODE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::prefix('profile')->group(function () {
        Route::get('/', [AuthController::class, 'profile']);
        Route::post('/update', [AuthController::class, 'updateProfile']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);
        Route::post('/upload-photo', [AuthController::class, 'uploadPhoto']);
        Route::delete('/delete-photo', [AuthController::class, 'deletePhoto']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard/summary', [DashboardController::class, 'summary']);

    /*
    |--------------------------------------------------------------------------
    | SANTRI
    |--------------------------------------------------------------------------
    */
    Route::prefix('santri')->group(function () {
        Route::get('/', [SantriController::class, 'index']);
        Route::post('/', [SantriController::class, 'store']);
        Route::get('/{id}', [SantriController::class, 'show']);
        Route::put('/{id}', [SantriController::class, 'update']);
        Route::delete('/{id}', [SantriController::class, 'destroy']);

        Route::put('/{id}/assign-kelas', [SantriController::class, 'assignKelas']);

        Route::post('/import', [SantriImportController::class, 'import']);
        Route::post('/import/preview', [SantriImportController::class, 'previewImport']);
        Route::get('/template', [SantriTemplateController::class, 'download']);
    });

    /*
    |--------------------------------------------------------------------------
    | USTADZ & PENGAJAR
    |--------------------------------------------------------------------------
    */
    Route::apiResource('ustadz', UstadzController::class);
    Route::apiResource('pengajar', PengajarController::class);

    /*
    |--------------------------------------------------------------------------
    | JADWAL
    |--------------------------------------------------------------------------
    */
    Route::apiResource('jadwal', JadwalMengajarController::class);

    /*
    |--------------------------------------------------------------------------
    | KELAS
    |--------------------------------------------------------------------------
    */
    Route::prefix('kelas')->group(function () {
        Route::get('/search', [KelasController::class, 'search']);
        Route::get('/filter/tingkat/{tingkat}', [KelasController::class, 'filterByTingkat']);
        Route::get('/filter/ustadz/{ustadzId}', [KelasController::class, 'filterByUstadz']);

        Route::get('/{id}/rekap-presensi', [KelasController::class, 'rekapPresensi']);
        Route::get('/{id}/statistik', [KelasController::class, 'statistik']);

        Route::get('/', [KelasController::class, 'index']);
        Route::post('/', [KelasController::class, 'store']);
        Route::get('/{id}', [KelasController::class, 'show']);
        Route::put('/{id}', [KelasController::class, 'update']);
        Route::delete('/{id}', [KelasController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | SETORAN & INFAQ
    |--------------------------------------------------------------------------
    */
    Route::apiResource('setoran', SetoranController::class)->only(['index', 'store', 'show']);
    Route::apiResource('infaq', InfaqController::class)->only(['index', 'store']);

    /*
    |--------------------------------------------------------------------------
    | GAJI
    |--------------------------------------------------------------------------
    */
    Route::apiResource('gaji', GajiController::class)->only(['index', 'store']);
    Route::get('/pengajar/rekap-gaji', [GajiPengajarRekapController::class, 'rekap']);

    /*
    |--------------------------------------------------------------------------
    | PRESENSI
    |--------------------------------------------------------------------------
    */
    Route::prefix('presensi')->group(function () {
        Route::post('/santri/masuk', [PresensiController::class, 'masukSantri']);
        Route::post('/santri/pulang', [PresensiController::class, 'pulangSantri']);
        Route::post('/ustadz/masuk', [PresensiController::class, 'masukUstadz']);
        Route::post('/ustadz/pulang', [PresensiController::class, 'pulangUstadz']);

        Route::get('/history', [PresensiController::class, 'history']);
        Route::get('/rekap/mingguan', [PresensiController::class, 'rekapMingguan']);
        Route::get('/rekap/bulanan', [PresensiController::class, 'rekapBulanan']);
    });

    /*
    |--------------------------------------------------------------------------
    | AKHLAK & NILAI
    |--------------------------------------------------------------------------
    */
    Route::apiResource('akhlak-santri', AkhlakSantriController::class)->only(['index', 'store']);
    Route::apiResource('nilai-ujian', NilaiUjianController::class)->only(['index', 'store']);

    /*
    |--------------------------------------------------------------------------
    | NOTIFICATIONS
    |--------------------------------------------------------------------------
    */
    Route::get('/notifications', [\App\Http\Controllers\Api\NotificationController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | FCM
    |--------------------------------------------------------------------------
    */
    Route::post('/fcm-token', [FcmTokenController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| ROLE-BASED ROUTES (TANPA token.expired — TEST MODE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'role:ADMIN'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'summary']);
        Route::get('/activity-logs', [ActivityLogController::class, 'index']);
        Route::get('/activity-logs/summary', [ActivityLogController::class, 'summary']);
        Route::get('/activity-logs/export/pdf', [ActivityLogController::class, 'exportPdf']);
        Route::get('/activity-logs/export/excel', [ActivityLogController::class, 'exportExcel']);
        Route::get('/activity-logs/export/csv', [ActivityLogController::class, 'exportCsv']);
    });

Route::middleware(['auth:sanctum', 'role:USTADZ'])
    ->prefix('ustadz')
    ->group(function () {
        Route::get('/kelas', [KelasController::class, 'kelasUstadz']);
        Route::get('/presensi', [PresensiController::class, 'historyUstadz']);
    });

Route::middleware(['auth:sanctum', 'role:SANTRI'])
    ->prefix('santri')
    ->group(function () {
        Route::get('/progress', [SantriController::class, 'progress']);
        Route::get('/presensi', [PresensiController::class, 'historySantri']);
    });
