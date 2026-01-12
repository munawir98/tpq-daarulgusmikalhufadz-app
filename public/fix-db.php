<?php
// fix-db.php
// Versi 3: THE FINAL WEAPON (Shell Execute)
// Mencoba menggunakan 'mysql' command line dari sistem operasi container.

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');

echo "<h1>MySQL Fixer V3 (Shell Exec)</h1>";
echo "Host: $host | User: $user <br><br>";

if (!$pass) die("Error: DB_PASSWORD kosong.");

// Command Query
$sql = "ALTER USER '$user'@'%' IDENTIFIED WITH mysql_native_password BY '$pass'; FLUSH PRIVILEGES;";

// Bikin command CLI
// mysql -h ... -P ... -u ... -p... -e "..."
// Hati-hati special character di password, tapi kita coba basic dulu.
$cmd = sprintf(
    "mysql -h %s -P %s -u %s -p'%s' -e \"%s\" 2>&1",
    escapeshellarg($host),
    escapeshellarg($port),
    escapeshellarg($user),
    $pass, // Password susah di-escape dengan escapeshellarg kadang kalau ada quote, kita coba raw single quote wrapper
    $sql
);

// Tampilkan command (sensor password dikit)
$sensorCmd = str_replace($pass, '******', $cmd);
echo "Working... Executing Command: <br><code>$sensorCmd</code><hr>";

// Eksekusi
$output = shell_exec($cmd);

echo "<pre>$output</pre>";

if (strpos($output, 'Access denied') !== false) {
    echo "<h3 style='color:red;'>GAGAL: Password salah atau akses ditolak.</h3>";
} elseif (strpos($output, 'command not found') !== false) {
    echo "<h3 style='color:red;'>GAGAL: Command 'mysql' tidak ada di server ini.</h3>";
} else {
    // Coba tes PHP connect biasa
    try {
        $dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass);
        echo "<h2 style='color:blue;'>SUKSES BESAR! PHP Sekarang bisa connect!</h2>";
    } catch (Exception $e) {
        if (empty($output)) {
             echo "<h3 style='color:green;'>Command Shell sepertinya sukses (tidak ada error output), tapi PHP masih belum connect. Coba refresh aplikasi utama.</h3>";
        } else {
             echo "<h3 style='color:orange;'>Command jalan, tapi PHP masih error: " . $e->getMessage() . "</h3>";
        }
    }
}
