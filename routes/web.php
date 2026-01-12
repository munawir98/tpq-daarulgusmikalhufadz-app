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
use App\Http\Controllers\Web\BiometricWebController;

/*
|--------------------------------------------------------------------------
| HEALTH CHECK (for Railway)
|--------------------------------------------------------------------------
*/
Route::get('/debug-db', function () {
    $debugInfo = [];
    $pdo = null;

    // 1. Check Config
    $debugInfo['config_db_host'] = config('database.connections.mysql.host');
    $debugInfo['config_db_port'] = config('database.connections.mysql.port');
    $debugInfo['config_db_database'] = config('database.connections.mysql.database');
    $debugInfo['config_db_username'] = config('database.connections.mysql.username');

    // 2. Try Connection
    try {
        $pdo = DB::connection()->getPdo();
        $debugInfo['connection_status'] = "CONNECTED";
        $debugInfo['database_name'] = DB::connection()->getDatabaseName();
        $debugInfo['server_version'] = $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    } catch (\Exception $e) {
        $debugInfo['connection_status'] = "FAILED";
        $debugInfo['error_message'] = $e->getMessage();
    }

    // 3. Get Tables if Connected
    $tables = [];
    if ($pdo) {
        try {
            $tables = collect(DB::select('SHOW TABLES'))->map(function ($val) {
                foreach ($val as $key => $tableName) {
                    return [
                        'name' => $tableName,
                        'count' => DB::table($tableName)->count()
                    ];
                }
            });
        } catch (\Exception $e) {
             $debugInfo['table_error'] = $e->getMessage();
        }
    }

    return view('debug_db', compact('tables', 'debugInfo'));
});

Route::get('/health', fn () => response()->json(['status' => 'ok'], 200));

// [TEMPORARY DEBUG] Check biometric credentials
Route::get('/debug-biometric', function () {
    try {
        $credentials = \App\Models\BiometricCredential::with('user.santri')->get();

        $output = "<h2>Data Sidik Jari Terdaftar</h2>";
        $output .= "<p>Total: " . $credentials->count() . " sidik jari</p>";
        $output .= "<table border='1' cellpadding='8' style='border-collapse: collapse;'>";
        $output .= "<tr><th>ID</th><th>User ID</th><th>Nama Santri</th><th>Credential Name</th><th>Created At</th></tr>";

        foreach ($credentials as $cred) {
            $santriName = $cred->user && $cred->user->santri ? $cred->user->santri->nama_lengkap : ($cred->user ? $cred->user->name : 'N/A');
            $output .= "<tr>";
            $output .= "<td>{$cred->id}</td>";
            $output .= "<td>{$cred->user_id}</td>";
            $output .= "<td>{$santriName}</td>";
            $output .= "<td>{$cred->name}</td>";
            $output .= "<td>{$cred->created_at}</td>";
            $output .= "</tr>";
        }

        $output .= "</table>";
        return $output;

    } catch (\Exception $e) {
        return "<h3>Error:</h3>" . $e->getMessage();
    }
});

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

// [TEMPORARY FIX] Auto-generate Ustadz Profiles for existing users
// [TEMPORARY FIX] Auto-generate Ustadz Profiles for existing users
Route::get('/fix-ustadz-data', function () {
    try {
        // 1. Cek Tabel
        if (!\Illuminate\Support\Facades\Schema::hasTable('ustadz')) {
             return "ERROR FATAL: Tabel 'ustadz' TIDAK ADA di database. Solusi: php artisan migrate";
        }

        $users = \App\Models\User::where('role', 'USTADZ')->doesntHave('ustadz')->get();
        $count = 0;
        $errors = [];

        foreach ($users as $user) {
            try {
                \App\Models\Ustadz::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nama' => $user->name,
                        'nik' => substr($user->nip ?? date('ym') . rand(1000, 9999), 0, 30), // Limit 30 chars
                        'status_aktif' => true,
                        'jenis_kelamin' => 'L',
                        'alamat' => '-',
                        'no_hp' => '-'
                    ]
                );
                $count++;
            } catch (\Exception $ex) {
                $errors[] = "Gagal User ID {$user->id}: " . $ex->getMessage();
            }
        }

        if (count($errors) > 0) {
            return "<h3>Proses Selesai dengan Beberapa Error:</h3>" . implode("<br>", $errors);
        }

        return "<h3>SUKSES!</h3> $count profil Ustadz berhasil dibuat/diperbaiki.<br>Silakan coba LOGIN lagi dengan akun lama.";

    } catch (\Exception $e) {
        return "<h3>FATAL ERROR:</h3> " . $e->getMessage();
    }
});

// [TEMPORARY FIX] Auto-generate Santri Profiles for existing users
Route::get('/fix-santri-data', function () {
    try {
        if (!\Illuminate\Support\Facades\Schema::hasTable('santri')) {
             return "ERROR FATAL: Tabel 'santri' TIDAK ADA di database.";
        }

        // Find SANTRI users without a santri profile
        $users = \App\Models\User::where('role', 'SANTRI')
            ->whereDoesntHave('santri')
            ->get();

        $count = 0;
        $errors = [];
        $skipped = [];

        foreach ($users as $user) {
            try {
                // Check if santri already exists for this user
                $existingSantri = \App\Models\Santri::where('user_id', $user->id)->first();
                if ($existingSantri) {
                    $skipped[] = "User ID {$user->id} ({$user->name}): Sudah ada profil santri";
                    continue;
                }

                // Generate unique NIS - check if exists and add suffix if needed
                $baseNis = 'NIS-' . date('Y') . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
                $nis = $baseNis;
                $suffix = 1;

                while (\App\Models\Santri::where('nis', $nis)->exists()) {
                    $nis = $baseNis . '-' . $suffix;
                    $suffix++;
                }

                \App\Models\Santri::create([
                    'user_id' => $user->id,
                    'nis' => $nis,
                    'nama_lengkap' => $user->name,
                    'nama_panggilan' => explode(' ', $user->name)[0], // First name
                    'jenis_kelamin' => 'L',
                    'status_aktif' => true,
                ]);
                $count++;
            } catch (\Exception $ex) {
                $errors[] = "Gagal User ID {$user->id} ({$user->name}): " . $ex->getMessage();
            }
        }

        $totalSantri = \App\Models\Santri::count();

        $output = "<h3>Proses Selesai</h3>";
        $output .= "<p>✅ Berhasil dibuat: $count profil santri</p>";

        if (count($skipped) > 0) {
            $output .= "<p>⏭️ Di-skip: " . count($skipped) . "</p>";
        }

        if (count($errors) > 0) {
            $output .= "<h4>❌ Errors:</h4>" . implode("<br>", $errors);
        }

        $output .= "<br><br><strong>Total Santri di DB: $totalSantri</strong>";

        return $output;

    } catch (\Exception $e) {
        return "<h3>FATAL ERROR:</h3> " . $e->getMessage();
    }
});

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
    Route::get('/info', fn () => view('pages.info'))->name('info');
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

        // Santri Management
        Route::resource('santri', \App\Http\Controllers\Web\UstadzSantriController::class);
        Route::get('santri/{id}/akhlak/create', [\App\Http\Controllers\Web\UstadzSantriController::class, 'createAkhlak'])->name('santri.akhlak.create');
        Route::post('santri/{id}/akhlak', [\App\Http\Controllers\Web\UstadzSantriController::class, 'storeAkhlak'])->name('santri.akhlak.store');


        Route::get('/kelas', fn () => view('ustadz.kelas'))
            ->name('kelas');

        Route::get('/menu', fn () => view('ustadz.menu'))
            ->name('menu');

        // Presensi Ustadz
        Route::get('/presensi', [PresensiWebController::class, 'ustadzIndex'])
            ->name('presensi');

        // Biometric
        Route::get('/biometric', [BiometricWebController::class, 'index'])->name('biometric.index');
        Route::post('/biometric', [BiometricWebController::class, 'store'])->name('biometric.store');
        Route::get('/biometric/attendance', [BiometricWebController::class, 'attendance'])->name('biometric.attendance');
        Route::post('/biometric/attendance', [BiometricWebController::class, 'submitAttendance'])->name('biometric.submit');

        Route::get('/biometric/register', [BiometricWebController::class, 'register'])->name('biometric.register');
        Route::get('/biometric/search', [BiometricWebController::class, 'search'])->name('biometric.search');
        Route::post('/biometric/register', [BiometricWebController::class, 'storeCredential'])->name('biometric.register.store');

        // Hafalan / Setoran

        Route::get('/presensi/pdf', function () {
            // In real app, pass data like $santri, $month, etc.
            return view('presensi.pdf_preview');
        })->name('presensi.pdf');

        Route::prefix('hafalan')->name('hafalan.')->group(function () {
            Route::get('/', [HafalanWebController::class, 'index'])->name('index');
            Route::get('/input', [HafalanWebController::class, 'inputForm'])->name('input');
            Route::get('/create', [HafalanWebController::class, 'create'])->name('create');
            Route::post('/', [HafalanWebController::class, 'store'])->name('store');
            Route::get('/last/{santriId}', [HafalanWebController::class, 'getLastHafalan'])->name('last');
            Route::get('/{id}/edit', [HafalanWebController::class, 'edit'])->name('edit');
            Route::put('/{id}', [HafalanWebController::class, 'update'])->name('update');
            Route::get('/{id}', [HafalanWebController::class, 'show'])->name('show');
            Route::get('/statistik/semua', [HafalanWebController::class, 'laporan'])->name('laporan');
        });

        // Laporan Hafalan
        // Hub Laporan
        Route::get('/laporan', fn() => view('ustadz.laporan.index'))->name('laporan.index');

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

