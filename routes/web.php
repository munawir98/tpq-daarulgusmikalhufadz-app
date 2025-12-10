<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ActivityLogController;

// -----------------------------------
// Laporan Absensi PDF
// -----------------------------------
Route::get('/laporan/absensi/{santri_id}/{bulan}', [LaporanController::class, 'absensiPdf']);


// -----------------------------------
// Halaman Utama
// -----------------------------------
Route::get('/', function () {
    return view('welcome');
});


// -----------------------------------
// Login
// -----------------------------------
Route::get('/login', [AuthWebController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthWebController::class, 'login'])->name('login.process');


// -----------------------------------
// Dashboard
// -----------------------------------
Route::get('/dashboard', function () {
    if (!session('api_token')) {
        return redirect()->route('login.form');
    }
    return view('dashboard');
})->name('dashboard');


// -----------------------------------
// Logout
// -----------------------------------
Route::post('/logout', function () {
    session()->flush();
    return redirect()->route('login.form');
})->name('logout');


// -----------------------------------
// Tes PDF
// -----------------------------------
Route::get('/tes-pdf', function () {
    $pdf = Pdf::loadView('pdf.tes', ['nama' => 'TPQ Daarul Gusmik']);
    return $pdf->download('tes.pdf');
});


// -----------------------------------
// Activity Logs (INDEX)
// -----------------------------------
Route::get('/activity-logs', [ActivityLogController::class, 'index'])
    ->name('activity.logs');


// -----------------------------------
// EXPORT ROUTES
// -----------------------------------
Route::get('/activity/export/excel', [ActivityLogController::class, 'excel'])
    ->name('activity.export.excel');

Route::get('/activity/export/csv', [ActivityLogController::class, 'csv'])
    ->name('activity.export.csv');

Route::get('/activity/export/pdf', [ActivityLogController::class, 'pdf'])
    ->name('activity.export.pdf');


// -----------------------------------
// Activity Summary API (CHART)
// -----------------------------------
Route::get('/activity-summary', [ActivityLogController::class, 'summary'])
    ->name('activity.summary');
