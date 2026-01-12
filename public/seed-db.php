<?php
// seed-db.php
// Skrip untuk mengisi data awal (Admin, Ustadz, dll)
// Karena database masih kosong setelah migrasi.

define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Illuminate\Http\Request::capture());

echo "<h1>Database Seeder Tool</h1>";
echo "Mencoba mengisi data awal (Admin & Santri)...<br><hr>";

try {
    Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    echo "<pre>" . Illuminate\Support\Facades\Artisan::output() . "</pre>";
    echo "<h2 style='color:green'>SEEDING SUKSES! Data Admin sudah dibuat.</h2>";

    // Tampilkan bocoran kredensial (Hanya ambil yang Admin)
    $admin = \App\Models\User::where('role', 'admin')->first();
    if ($admin) {
        echo "<h3>Default Admin:</h3>";
        echo "<b>Email:</b> " . $admin->email . "<br>";
        echo "<b>Password:</b> 20101996 (Sesuai DatabaseSeeder)<br>";
    }
} catch (\Exception $e) {
    echo "<h2 style='color:red'>Seeding Gagal</h2>";
    echo "Error: " . $e->getMessage();
}
