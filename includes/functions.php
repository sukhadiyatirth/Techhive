<?php
// includes/functions.php

/**
 * Format price to standard currency format
 */
function formatPrice($price) {
    return '$' . number_format((float)$price, 2, '.', ',');
}

/**
 * Sanitize user input
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Redirect utility
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Get product by slug
 */
function getProductBySlug($pdo, $slug) {
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name, b.name as brand_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.category_id 
        LEFT JOIN brands b ON p.brand_id = b.brand_id 
        WHERE p.slug = ? AND p.status != 'inactive'
    ");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}
