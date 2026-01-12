<?php
// fix-db.php
// Skrip Darurat untuk Mengubah Authentication Method MySQL di Railway
// Buka file ini di browser: https://app-kakak.up.railway.app/fix-db.php

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$db   = getenv('DB_DATABASE'); // Tidak dipake buat connect awal
$user = getenv('DB_USERNAME');

// AMBIL PASSWORD LANGSUNG DARI ENV
// Pastikan variable ini ada di Railway (biasanya DB_PASSWORD)
$pass = getenv('DB_PASSWORD');

echo "<h1>MySQL Fixer</h1>";
echo "Mencoba koneksi ke Host: $host | User: $user<br>";

if (!$pass) {
    die("Error: DB_PASSWORD tidak terbaca dari Environment Variable.");
}

try {
    // Kita connect TANPA database dulu karena kadang connect ke DB langsung ditolak kalau auth beda
    // Tapi karena kita mau ubah user, kita login biasa dulu.
    // Kalau login biasa gagal karena auth plugin, maka skrip ini pun gagal.
    // TAPI: PDO PHP modern biasanya support caching_sha2_password. Masalahnya di Laravel/Driver lama.
    // Jadi harapan kita: PHP Native ini BISA connect, lalu jalankan query buat fix user.

    $dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Koneksi Native PHP: BERHASIL! <br>";

    // QUERY SAKTI
    $query = "ALTER USER '$user'@'%' IDENTIFIED WITH mysql_native_password BY '$pass';";
    echo "Menjalankan Query: $query <br>";

    $pdo->exec($query);
    echo "<h3>SUKSES! User '$user' sekarang menggunakan mysql_native_password.</h3>";

    $pdo->exec("FLUSH PRIVILEGES;");
    echo "Privileges Flushed. Silakan coba buka aplikasi Laravel lagi.";

} catch (\PDOException $e) {
    echo "<h3>GAGAL KONEKSI / EKSEKUSI</h3>";
    echo "Pesan Error: " . $e->getMessage() . "<br>";
    echo "Code: " . $e->getCode();
}
