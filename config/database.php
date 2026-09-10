<?php
// config/database.php

$host = '127.0.0.1';
$dbname = 'techhive_db';
$username = 'root'; // default XAMPP username
$password = ''; // default XAMPP password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Handle connection error gracefully
    // In production, avoid exposing the exact error message to the user
    die("Database connection failed. Error: " . $e->getMessage());
}
?>
