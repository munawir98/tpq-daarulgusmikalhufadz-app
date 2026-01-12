<?php
// fix-db.php V5 (Restore Default)
// Mengembalikan user ke caching_sha2_password agar kompatibel dengan PHP 8.2+

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');

echo "<h1>MySQL Fixer V5 (Restore Default)</h1>";

// Kita akan memaksa user kembali ke DEFAULT MySQL 8 karena kita sudah downgrade PHP
// PHP 8.2 + caching_sha2_password HARUSNYA works.

$targetAlgo = 'caching_sha2_password';
$sql = "ALTER USER '$user'@'%' IDENTIFIED WITH $targetAlgo BY '$pass'; FLUSH PRIVILEGES;";

// Pakai Shell Exec yang terbukti jalan (karena kita punya mysql client sekarang)
$cmdFix = sprintf("mysql -h %s -P %s -u %s -p'%s' -e \"%s\" 2>&1", $host, $port, $user, $pass, $sql);

echo "Running Reset Command: <br><code>$sql</code><br><hr>";
$output = shell_exec($cmdFix);

echo "<pre>$output</pre>";

if (empty($output)) {
    echo "<h2 style='color:green'>SUCCESS! User Reset to 'caching_sha2_password'.</h2>";
    echo "<h3>Now please Refresh your Main App / Login Page.</h3>";
} else {
    echo "<h2 style='color:red'>Command Finished with Output (Check for errors above).</h2>";
}

// Test PHP Connection
echo "<hr><h3>Final PHP Connection Test:</h3>";
try {
    $dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    echo "<b style='color:blue'>PHP CONNECTION: OK! (Connected via PDO)</b>";
} catch (Exception $e) {
    echo "<b style='color:red'>PHP CONNECTION: FAILED.</b><br>";
    echo $e->getMessage();
}
