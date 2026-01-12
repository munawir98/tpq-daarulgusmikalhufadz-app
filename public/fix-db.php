<?php
// fix-db.php V4 (Diagnostic Mode)

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');

echo "<h1>MySQL Fixer V4 (Diagnostic)</h1>";

// 1. Cek Driver PHP
echo "<h3>1. PHP Driver Check</h3>";
if (extension_loaded('pdo_mysql')) {
    echo "PDO MySQL Loaded. Client Info: " .  pdo_drivers()['mysql'] ?? 'Unknown';
    echo "<pre>";
    $info = (new ReflectionExtension('pdo_mysql'))->info();
    print_r($info);
    echo "</pre>";
} else {
    echo "<b style='color:red'>PDO MySQL Extension NOT Loaded!</b><br>";
}

if (extension_loaded('mysqlnd')) {
    echo "<b style='color:green'>MySQL Native Driver (mysqlnd) is LOADED!</b>";
} else {
    echo "<b style='color:red'>MySQL Native Driver (mysqlnd) is NOT LOADED! (This is bad)</b>";
}

echo "<hr>";

// 2. Cek Support Plugin di Server via Shell
echo "<h3>2. Server Plugin Check</h3>";
// Kita pakai mysql CLI yang sudah ada (semoga)
$cmdPlugins = sprintf("mysql -h %s -P %s -u %s -p'%s' -e \"SHOW PLUGINS;\" 2>&1", $host, $port, $user, $pass);
$outputPlugins = shell_exec($cmdPlugins);

echo "<pre>$outputPlugins</pre>";

// 3. Analisis & Action
if (strpos($outputPlugins, 'mysql_native_password') !== false && strpos($outputPlugins, 'ACTIVE') !== false) {
    echo "<b>mysql_native_password detected!</b> Trying to use it...<br>";
    $targetAlgo = 'mysql_native_password';
} elseif (strpos($outputPlugins, 'sha256_password') !== false && strpos($outputPlugins, 'ACTIVE') !== false) {
    echo "<b>sha256_password detected!</b> Native not found. Trying to use sha256_password...<br>";
    $targetAlgo = 'sha256_password';
} else {
    echo "<b style='color:red'>No compatible legacy plugins found active. Server seems to enforce caching_sha2_password only.</b><br>";
    $targetAlgo = null;
}

if ($targetAlgo) {
    $sql = "ALTER USER '$user'@'%' IDENTIFIED WITH $targetAlgo BY '$pass'; FLUSH PRIVILEGES;";
    $cmdFix = sprintf("mysql -h %s -P %s -u %s -p'%s' -e \"%s\" 2>&1", $host, $port, $user, $pass, $sql);

    echo "Running Fix Command: <code>$sql</code><br>";
    $fixOutput = shell_exec($cmdFix);
    echo "<pre>$fixOutput</pre>";

    if (empty($fixOutput)) echo "<h2 style='color:blue'>Fix Command Executed Successfully (No Errors)</h2>";
}
