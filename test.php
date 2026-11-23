<?php
$host = '127.0.0.1';
$port = 3307;

try {
    // Connect to MySQL on port 3307
    $pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", 'root', '');
    echo "<h3>✅ Successfully connected to MySQL on port $port!</h3>";
    
    // Ask for all databases
    $stmt = $pdo->query("SHOW DATABASES");
    $dbs = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<strong>Here are the databases on this MySQL server:</strong><br><ul>";
    foreach ($dbs as $db) {
        if ($db == 'techbound') {
            echo "<li><strong style='color:green;'>$db (FOUND IT!)</strong></li>";
        } else {
            echo "<li>$db</li>";
        }
    }
    echo "</ul>";

} catch (Exception $e) {
    echo "<h3 style='color:red;'>❌ Connection failed:</h3>";
    echo $e->getMessage();
}
?>