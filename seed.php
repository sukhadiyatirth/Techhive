<?php
// seed.php - Seed and Reset Database Script for TechHive Electronic

$host = '127.0.0.1';
$dbname = 'techhive_db';
$username = 'root';
$password = '';

header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Database Seeder - TechHive</title><style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #0a0a0a; color: #fff; padding: 2rem; max-width: 800px; margin: 0 auto; }
.card { background: #141414; border: 1px solid #2a2a2a; border-radius: 12px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
h1 { color: #d4af37; margin-top: 0; }
.success { color: #00c851; background: rgba(0,200,81,0.1); border: 1px solid #00c851; padding: 1rem; border-radius: 6px; margin: 1rem 0; }
.error { color: #ff4444; background: rgba(255,68,68,0.1); border: 1px solid #ff4444; padding: 1rem; border-radius: 6px; margin: 1rem 0; }
pre { background: #000; padding: 1rem; border-radius: 6px; overflow-x: auto; color: #a0a0a0; }
a.btn { display: inline-block; background: #d4af37; color: #000; padding: 0.75rem 1.5rem; text-decoration: none; font-weight: bold; border-radius: 6px; margin-top: 1rem; }
</style></head><body><div class='card'><h1>TechHive Database Seeder</h1>";

try {
    // 1. Connect without selecting database to ensure it exists
    $pdoRoot = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdoRoot->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if not exists
    $pdoRoot->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    echo "<p>✔️ Database <code>$dbname</code> verified/created.</p>";
    
    // 2. Connect to techhive_db
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. Read database.sql
    $sqlFile = __DIR__ . '/database.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("database.sql file not found in root directory.");
    }
    
    $rawSql = file_get_contents($sqlFile);
    // Strip BOM if present
    $rawSql = preg_replace('/^\xEF\xBB\xBF/', '', $rawSql);

    // Split SQL into individual statements
    $statements = array_filter(
        array_map('trim', explode(";\n", $rawSql)),
        function($stmt) {
            return !empty($stmt) && strpos($stmt, '--') !== 0;
        }
    );

    foreach ($statements as $statement) {
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }
    
    // Verify counts
    $productCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $categoryCount = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    $brandCount = $pdo->query("SELECT COUNT(*) FROM brands")->fetchColumn();

    echo "<div class='success'>
        <h3>🎉 Database Seeded Successfully!</h3>
        <p>Your database <strong>$dbname</strong> has been completely restored and seeded with fresh data.</p>
        <ul>
            <li><strong>Categories:</strong> $categoryCount</li>
            <li><strong>Brands:</strong> $brandCount</li>
            <li><strong>Products:</strong> $productCount items</li>
        </ul>
    </div>";

    echo "<h3>Credentials Reference:</h3>
    <pre>
Admin Panel: http://localhost/TechHive%20Electronic/admin/login.php
Admin User : admin@techhive.com / admin123

Customer Login: http://localhost/TechHive%20Electronic/login.php
Demo Customer : john@example.com / password123
    </pre>";

    echo "<a href='index.php' class='btn'>Go to TechHive Store &rarr;</a>";

} catch (Exception $e) {
    echo "<div class='error'>
        <h3>❌ Seeding Failed</h3>
        <p>" . htmlspecialchars($e->getMessage()) . "</p>
    </div>";
}

echo "</div></body></html>";
