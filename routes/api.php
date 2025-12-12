<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| CONTROLLER IMPORTS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Api\NilaiUjianController;
// AUTH & PROFILE
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


// AKHLAK SANTRI
use App\Http\Controllers\Api\AkhlakSantriController;

// ACTIVITY LOGS
use App\Http\Controllers\Api\ActivityLogController;


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Require Token)
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
        Route::post('/chat/private/typing', [ChatPrivateController::class, 'typing']);

    });


    /*
    |--------------------------------------------------------------------------
    | GROUP CHAT
    |--------------------------------------------------------------------------
    */
    Route::prefix('group')->group(function () {

        // GROUP MANAGEMENT
        Route::get('/', [GroupController::class, 'index']);
        Route::post('/', [GroupController::class, 'store']);
        Route::post('/{id}/add', [GroupController::class, 'addMember']);
        Route::get('/{id}/members', [GroupController::class, 'members']);
        Route::put('/{id}', [GroupController::class, 'rename']);
        Route::delete('/{id}', [GroupController::class, 'destroy']);
        Route::delete('/{groupId}/member/{userId}', [GroupController::class, 'removeMember']);

        // CHAT MESSAGE
        Route::get('/{id}/chat', [GroupMessageController::class, 'getMessages']);
        Route::post('/chat/send', [GroupMessageController::class, 'send']);
        Route::post('/chat/send-image', [GroupMessageController::class, 'sendImage']);
        Route::post('/chat/read', [GroupMessageController::class, 'markAsRead']);
        Route::post('/chat/typing', [GroupMessageController::class, 'typing']);
        Route::get('/{id}/typing', [GroupController::class, 'checkTyping']);
    });


    /*
    |--------------------------------------------------------------------------
    | PRESENSI
    |--------------------------------------------------------------------------
    */
    Route::prefix('presensi')->group(function () {

        Route::post('/masuk', [PresensiController::class, 'masukSantri']);
        Route::post('/pulang', [PresensiController::class, 'pulangSantri']);

        // USTADZ PRESENSI
        Route::prefix('ustadz')->group(function () {
            Route::post('/masuk', [PresensiController::class, 'masukUstadz']);
            Route::post('/pulang', [PresensiController::class, 'pulangUstadz']);
        });

        Route::get('/history', [PresensiController::class, 'history']);
        Route::get('/mingguan', [PresensiController::class, 'rekapMingguan']);
        Route::get('/bulanan', [PresensiController::class, 'rekapBulanan']);
        Route::get('/today/santri/{id}', [PresensiController::class, 'todaySantri']);
        Route::get('/today/ustadz/{id}', [PresensiController::class, 'todayUstadz']);
    });


    /*
    |--------------------------------------------------------------------------
    | PRESENSI EXPORT & DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/presensi/export/pdf', [PresensiPdfController::class, 'export']);
    Route::get('/presensi/export/excel', [PresensiExportController::class, 'export']);
    Route::get('/presensi/dashboard', [PresensiDashboardController::class, 'summary']);
    Route::get('/presensi/chart', [PresensiChartController::class, 'chart']);
    Route::get('/presensi/daily', [PresensiLaporanController::class, 'daily']);
    Route::get('/presensi/weekly', [PresensiLaporanController::class, 'weekly']);
    Route::get('/presensi/laporan-bulanan/{bulan}', [PresensiController::class, 'downloadBulanan']);


    /*
    |--------------------------------------------------------------------------
    | ADMIN PRESENSI
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:ADMIN')->group(function () {

        Route::get('/admin/presensi/rekap-bulanan', [AdminPresensiRekapController::class, 'monthly']);
        Route::get('/admin/presensi/chart/{bulan}', [PresensiChartController::class, 'chartBulanan']);
        Route::get('/admin/presensi/chart-tahunan/{tahun}', [PresensiChartController::class, 'chartTahunan']);
        Route::get('/admin/presensi/range', [PresensiChartController::class, 'chartRange']);
        Route::get('/admin/presensi/filter', [PresensiController::class, 'filter']);

        Route::get('/kelas/presensi/rekap', [KelasPresensiRekapController::class, 'rekap']);
    });


    /*
    |--------------------------------------------------------------------------
    | ACTIVITY LOGS
    |--------------------------------------------------------------------------
    */
    Route::get('/activity-logs', [ActivityLogController::class, 'index']);
    Route::get('/activity-summary', [ActivityLogController::class, 'summary']);


    /*
    |--------------------------------------------------------------------------
    | AKHLAK SANTRI
    |--------------------------------------------------------------------------
    */
    Route::prefix('akhlak-santri')->group(function () {

        Route::get('/', [AkhlakSantriController::class, 'index']);
        Route::get('/{id}', [AkhlakSantriController::class, 'show']);
        Route::post('/', [AkhlakSantriController::class, 'store']);
        Route::put('/{id}', [AkhlakSantriController::class, 'update']);
        Route::delete('/{id}', [AkhlakSantriController::class, 'destroy']);

        Route::get('/santri/{santriId}', [AkhlakSantriController::class, 'bySantri']);

        Route::get('/laporan/bulanan/{santri_id}', [AkhlakSantriController::class, 'laporanBulanan']);
    });

        Route::prefix('nilai-ujian')->group(function () {
        Route::get('/', [NilaiUjianController::class, 'index']);
        Route::get('/{id}', [NilaiUjianController::class, 'show']);
        Route::post('/', [NilaiUjianController::class, 'store']);
        Route::put('/{id}', [NilaiUjianController::class, 'update']);
        Route::delete('/{id}', [NilaiUjianController::class, 'destroy']);

        // Filter nilai ujian per santri
        Route::get('/santri/{santriId}', [NilaiUjianController::class, 'bySantri']);
    });

        Route::post('fcm-token', [FcmTokenController::class, 'store'])->middleware('auth:sanctum');
        Route::post('/fcm/save', [FcmTokenController::class, 'store']);

        Route::get('/chat/private/unread-count', [ChatPrivateController::class, 'unreadCount']);
        Route::post('/chat/private/status', [ChatPrivateController::class, 'setStatusChat']);

        Route::get('/group/{group}/mention/search', [GroupController::class, 'searchMention']);
        Route::get('/group/{group}/detail', [GroupController::class, 'detail']);
        Route::get('/groups/my', [GroupController::class, 'myGroups']);
        Route::get('/groups/roles', [GroupController::class, 'roleList']);






});
