<?php
// fix-db.php
// Versi 2: Menggunakan MySQLi (bukan PDO) untuk kompatibilitas Auth lebih baik

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');
$db   = getenv('DB_DATABASE');

echo "<h1>MySQL Fixer V2 (MySQLi)</h1>";
echo "Host: $host | User: $user <br>";

if (!$pass) die("Error: DB_PASSWORD kosong.");

// Coba Connect pakai MySQLi
$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    echo "<h3 style='color:red;'>Koneksi Gagal: " . $conn->connect_error . "</h3>";
    echo "Tips: Jika errornya 'caching_sha2_password', berarti driver PHP di server ini benar-benar tidak support.";
    exit;
}

echo "<h3 style='color:green;'>Koneksi Berhasil!</h3>";

// Jalankan Query Fix
$sql = "ALTER USER '$user'@'%' IDENTIFIED WITH mysql_native_password BY '$pass'";
echo "Menjalankan: $sql ... <br>";

if ($conn->query($sql) === TRUE) {
    echo "<h2 style='color:blue;'>SUKSES! Password Plugin Berhasil Diubah.</h2>";
    $conn->query("FLUSH PRIVILEGES");
    echo "Privileges Flushed. SELESAI. Silakan buka aplikasi.";
} else {
    echo "Error menjalankan query: " . $conn->error;
}

$conn->close();
