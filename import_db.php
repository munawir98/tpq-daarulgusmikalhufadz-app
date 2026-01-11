<?php

echo "========================================\n";
echo "   MIGRASI DATABASE LOKAL KE RAILWAY    \n";
echo "========================================\n\n";

// 1. Ask for SQL File Path
echo "[1/2] Masukkan lokasi file SQL (Drag file .sql ke sini lalu tekan Enter):\n> ";
$handle = fopen("php://stdin", "r");
$line = fgets($handle);
$filePath = trim(trim($line), '"\''); // Remove quotes if added by drag-n-drop

if (!file_exists($filePath)) {
    die("❌ Error: File tidak ditemukan di '$filePath'. Pastikan path benar.\n");
}

echo "\n[INFO] Membaca file SQL... ";
$sql = file_get_contents($filePath);
if (!$sql) {
    die("❌ Gagal membaca file.\n");
}

// REMOVE any internal SET FOREIGN_KEY_CHECKS commands
$sql = preg_replace('/SET\s+FOREIGN_KEY_CHECKS\s*=\s*[01]\s*;/i', '', $sql);
$sql = preg_replace('/SET\s+@OLD_FOREIGN_KEY_CHECKS.*;/i', '', $sql);

// AGGRESSIVE: Remove Foreign Key Constraints
// 1. Remove ALTER TABLE ... ADD CONSTRAINT ... FOREIGN KEY ...;
$sql = preg_replace('/ALTER\s+TABLE\s+[`\'"]?\w+[`\'"]?\s+ADD\s+CONSTRAINT\s+[`\'"]?\w+[`\'"]?\s+FOREIGN\s+KEY\s*\([^;]+;/i', '', $sql);

// 2. Remove inline CONSTRAINT ... FOREIGN KEY inside CREATE TABLE
$sql = preg_replace('/,\s*CONSTRAINT\s+[`\'"]?\w+[`\'"]?\s+FOREIGN\s+KEY\s*\([^)]+\)\s*REFERENCES\s+[`\'"]?\w+[`\'"]?\s*\([^)]+\)(\s*ON\s+DELETE\s+\w+)?(\s*ON\s+UPDATE\s+\w+)?/i', '', $sql);

// 3. Simple cleanup for any remaining FK definitions
$sql = preg_replace('/FOREIGN\s+KEY\s*\([^)]+\)\s*REFERENCES\s+[^,)]+/i', '', $sql);

// Clean up dangling commas and empty statements
$sql = preg_replace('/,\s*\)/', ')', $sql);
$sql = preg_replace('/;\s*;/s', ';', $sql);

echo "OK (" . strlen($sql) . " bytes) - Foreign Keys Removed (ALTER & CREATE)\n";

// 2. Ask for Railway Credentials
echo "\n[2/2] Masukkan Kredensial Database Railway (Cek di Dashboard Railway -> MySQL -> Connect)\n";

echo "Host (contoh: roundhouse.proxy.rlwy.net): ";
$host = trim(fgets($handle));

echo "Port (contoh: 12345): ";
$port = trim(fgets($handle));

echo "Database NameFor (contoh: railway): ";
$dbname = trim(fgets($handle));

echo "Username (contoh: root): ";
$username = trim(fgets($handle));

echo "Password: ";
$password = trim(fgets($handle));

echo "\n[INFO] Menghubungkan ke Railway... ";

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 30, // 30 seconds timeout
    ];

    $pdo = new PDO($dsn, $username, $password, $options);
    echo "BERHASIL TERHUBUNG! ✅\n";

    echo "\n[INFO] Membersihkan database lama di Railway... ";

    // Disable FK checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    // Get all tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (count($tables) > 0) {
        foreach ($tables as $table) {
            $pdo->exec("DROP TABLE IF EXISTS `$table`");
        }
    }
    echo "BERSIH! ✨\n";

    echo "\n[INFO] Sedang mengimport data baru...\n";

    // Execute SQL
    $pdo->exec($sql);

    // Re-enable FK checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    echo "\n========================================\n";
    echo "✅ SUKSES! DATABASE BERHASIL DI-UPLOAD KE RAILWAY\n";
    echo "========================================\n";
    echo "Sekarang aplikasi Kakak di Railway sudah punya data yang sama dengan di lokal.\n";

} catch (PDOException $e) {
    echo "\n❌ GAGAL TERHUBUNG ATAU IMPORT ERROR:\n";
    echo $e->getMessage() . "\n";
    echo "Pastikan Host, Port, Password benar dan Service MySQL di Railway menyala.\n";
}

fclose($handle);
