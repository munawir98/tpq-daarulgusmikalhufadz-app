<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLER IMPORTS
|--------------------------------------------------------------------------
*/

// AUTH
use App\Http\Controllers\Api\AuthController;

// MASTER DATA
use App\Http\Controllers\Api\SantriController;
use App\Http\Controllers\Api\PengajarController;
use App\Http\Controllers\Api\UstadzController;
use App\Http\Controllers\Api\JadwalMengajarController;
use App\Http\Controllers\Api\KelasController;

// SETORAN & INFAQ
use App\Http\Controllers\Api\SetoranController;
use App\Http\Controllers\Api\InfaqController;

// GAJI
use App\Http\Controllers\Api\GajiController;
use App\Http\Controllers\Api\GajiPengajarRekapController;

// PRESENSI
use App\Http\Controllers\Api\PresensiController;
use App\Http\Controllers\Api\PresensiPdfController;
use App\Http\Controllers\Api\PresensiExportController;
use App\Http\Controllers\Api\PresensiDashboardController;
use App\Http\Controllers\Api\PresensiChartController;
use App\Http\Controllers\Api\PresensiLaporanController;
use App\Http\Controllers\Api\AdminPresensiRekapController;
use App\Http\Controllers\Api\KelasPresensiRekapController;

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
| PUBLIC AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (SANCTUM)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile/upload-photo', [AuthController::class, 'uploadPhoto']);
    Route::delete('/profile/delete-photo', [AuthController::class, 'deletePhoto']);
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);
    Route::post('/profile/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | MASTER DATA
    |--------------------------------------------------------------------------
    */
    Route::apiResource('santri', SantriController::class);
    Route::apiResource('ustadz', UstadzController::class);
    Route::apiResource('pengajar', PengajarController::class);
    Route::apiResource('jadwal', JadwalMengajarController::class);

    Route::get('/kelas/search', [KelasController::class, 'search']);
    Route::apiResource('kelas', KelasController::class);

    /*
    |--------------------------------------------------------------------------
    | SETORAN & INFAQ
    |--------------------------------------------------------------------------
    */
    Route::apiResource('setoran', SetoranController::class);
    Route::apiResource('infaq', InfaqController::class);

    /*
    |--------------------------------------------------------------------------
    | GAJI
    |--------------------------------------------------------------------------
    */
    Route::apiResource('gaji', GajiController::class);
    Route::get('/pengajar/rekap-gaji', [GajiPengajarRekapController::class, 'rekap']);

    /*
    |--------------------------------------------------------------------------
    | PRIVATE CHAT
    |--------------------------------------------------------------------------
    */
    Route::prefix('chat/private')->group(function () {
        Route::get('/', [ChatPrivateController::class, 'list']);
        Route::get('/with/{user_id}', [ChatPrivateController::class, 'chatWith']);
        Route::post('/send', [ChatPrivateController::class, 'send']);
        Route::post('/read', [ChatPrivateController::class, 'markAsRead']);
        Route::post('/typing', [ChatPrivateController::class, 'typing']);
        Route::get('/unread-count', [ChatPrivateController::class, 'unreadCount']);
        Route::post('/status', [ChatPrivateController::class, 'setStatusChat']);
    });

    /*
    |--------------------------------------------------------------------------
    | GROUP CHAT
    |--------------------------------------------------------------------------
    */
    Route::prefix('group')->group(function () {
        Route::get('/', [GroupController::class, 'index']);
        Route::post('/', [GroupController::class, 'store']);
        Route::post('/{id}/add', [GroupController::class, 'addMember']);
        Route::get('/{id}/members', [GroupController::class, 'members']);
        Route::put('/{id}', [GroupController::class, 'rename']);
        Route::delete('/{id}', [GroupController::class, 'destroy']);
        Route::delete('/{groupId}/member/{userId}', [GroupController::class, 'removeMember']);

        Route::get('/{id}/chat', [GroupMessageController::class, 'getMessages']);
        Route::post('/chat/send', [GroupMessageController::class, 'send']);
        Route::post('/chat/read', [GroupMessageController::class, 'markAsRead']);
        Route::post('/chat/typing', [GroupMessageController::class, 'typing']);
    });

    /*
    |--------------------------------------------------------------------------
    | PRESENSI
    |--------------------------------------------------------------------------
    */
    Route::prefix('presensi')->group(function () {
        Route::post('/masuk', [PresensiController::class, 'masukSantri']);
        Route::post('/pulang', [PresensiController::class, 'pulangSantri']);

        Route::prefix('ustadz')->group(function () {
            Route::post('/masuk', [PresensiController::class, 'masukUstadz']);
            Route::post('/pulang', [PresensiController::class, 'pulangUstadz']);
        });

        Route::get('/history', [PresensiController::class, 'history']);
        Route::get('/mingguan', [PresensiController::class, 'rekapMingguan']);
        Route::get('/bulanan', [PresensiController::class, 'rekapBulanan']);
    });

    /*
    |--------------------------------------------------------------------------
    | PRESENSI REPORT
    |--------------------------------------------------------------------------
    */
    Route::get('/presensi/export/pdf', [PresensiPdfController::class, 'export']);
    Route::get('/presensi/export/excel', [PresensiExportController::class, 'export']);
    Route::get('/presensi/dashboard', [PresensiDashboardController::class, 'summary']);
    Route::get('/presensi/chart', [PresensiChartController::class, 'chart']);
    Route::get('/presensi/daily', [PresensiLaporanController::class, 'daily']);
    Route::get('/presensi/weekly', [PresensiLaporanController::class, 'weekly']);

    /*
    |--------------------------------------------------------------------------
    | ADMIN PRESENSI
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:ADMIN')->group(function () {
        Route::get('/admin/presensi/rekap-bulanan', [AdminPresensiRekapController::class, 'monthly']);
        Route::get('/kelas/presensi/rekap', [KelasPresensiRekapController::class, 'rekap']);
    });

    /*
    |--------------------------------------------------------------------------
    | AKHLAK & NILAI
    |--------------------------------------------------------------------------
    */
    Route::apiResource('akhlak-santri', AkhlakSantriController::class);
    Route::apiResource('nilai-ujian', NilaiUjianController::class);

    /*
    |--------------------------------------------------------------------------
    | ACTIVITY LOG
    |--------------------------------------------------------------------------
    */
    Route::get('/activity-logs', [ActivityLogController::class, 'index']);
    Route::get('/activity-summary', [ActivityLogController::class, 'summary']);

    /*
    |--------------------------------------------------------------------------
    | FCM TOKEN (FINAL, SATU ROUTE SAJA)
    |--------------------------------------------------------------------------
    */
    Route::post('/fcm-token', [FcmTokenController::class, 'store']);
});
