<?php
// migrate-db.php
// Skrip untuk menjalankan migrasi database Laravel secara manual

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<h1>Database Migration Tool</h1>";
echo "Mencoba membuat tabel database...<br><hr>";

try {
    Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo "<pre>" . Illuminate\Support\Facades\Artisan::output() . "</pre>";
    echo "<h2 style='color:green'>MIGRASI SUKSES! Tabel sudah dibuat.</h2>";
    echo "<h3>Sekarang silakan buka Root Website Aplikasi Kakak.</h3>";
} catch (\Exception $e) {
    echo "<h2 style='color:red'>Migrasi Gagal</h2>";
    echo "Error: " . $e->getMessage();
}
