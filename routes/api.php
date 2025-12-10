<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    SantriController,
    PengajarController,
    UstadzController,
    JadwalMengajarController,
    KelasController,
    PresensiController,
    PresensiPdfController,
    PresensiExportController,
    PresensiDashboardController,
    PresensiChartController,
    PresensiLaporanController,
    AdminPresensiRekapController,
    KelasPresensiRekapController,
    SetoranController,
    InfaqController,
    GajiController,
    GajiPengajarRekapController,
    GroupController,
    GroupMessageController,
    ChatPrivateController
};

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
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
    | PRIVATE CHAT (WhatsApp style)
    |--------------------------------------------------------------------------
    */
    Route::prefix('chat/private')->group(function () {

        Route::get('/', [ChatPrivateController::class, 'list']);                // list conversations
        Route::get('/with/{user_id}', [ChatPrivateController::class, 'chatWith']); // chat detail aman

        Route::post('/send', [ChatPrivateController::class, 'send']);
        Route::post('/read', [ChatPrivateController::class, 'markAsRead']);

        // TYPING indicator realtime
        Route::post('/typing', [ChatPrivateController::class, 'typing']);
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
    | LAPORAN & EXPORT PRESENSI
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
    | ROLE TESTING ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:superadmin')->get('/admin-only', fn() => "Ini halaman Superadmin");
    Route::middleware(['role:admin,superadmin'])->get('/manage-users', fn() => "Admin & Superadmin boleh akses");
    Route::middleware('role:ustadz')->get('/ustadz-only', fn() => "Ini halaman ustadz");

    Route::middleware(['auth', 'admin']) // jika hanya admin yg boleh
    ->get('/activity-logs', [ActivityLogController::class, 'index'])
    ->name('activity.logs');

    Route::get('/api/activity-logs', function () {
    return \Spatie\Activitylog\Models\Activity::with('causer')
        ->latest()
        ->paginate(30);
    });
    Route::get('/activity-summary', [ActivityLogController::class, 'summary']);



});
