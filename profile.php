<?php
// profile.php
require_once 'includes/auth.php'; // Protects this page
require_once 'config/database.php';

$userId = $_SESSION['user_id'];

// Fetch user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

// Fetch summary stats
$stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ?");
$stmt->execute([$userId]);
$totalOrders = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ? AND order_status = 'pending'");
$stmt->execute([$userId]);
$pendingOrders = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ? AND order_status = 'delivered'");
$stmt->execute([$userId]);
$deliveredOrders = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = ?");
$stmt->execute([$userId]);
$wishlistCount = $stmt->fetchColumn();

$pageTitle = 'My Dashboard - TechHive Electronic';
include 'includes/header.php';
?>

<div style="background: var(--surface); padding-top: 100px; padding-bottom: 2rem; border-bottom: 1px solid var(--border);">
    <div class="container">
        <h1 style="font-size: 2.5rem; letter-spacing: -0.03em;">My Account</h1>
        <p style="color: var(--muted); margin-top: 0.5rem;">Welcome back, <?= htmlspecialchars($user['full_name']) ?>!</p>
    </div>
</div>

<section class="container section-padding" style="padding-top: 3rem;">
    <div class="dashboard-layout">
        <!-- Sidebar -->
        <aside class="dashboard-sidebar">
            <nav class="dashboard-nav">
                <a href="profile.php" class="active"><i data-lucide="layout-dashboard"></i> Dashboard</a>
                <a href="orders.php"><i data-lucide="package"></i> My Orders</a>
                <a href="wishlist.php"><i data-lucide="heart"></i> Wishlist</a>
                <a href="#"><i data-lucide="map-pin"></i> Addresses</a>
                <a href="#"><i data-lucide="user"></i> Account Details</a>
                <a href="logout.php" style="color: var(--error);"><i data-lucide="log-out"></i> Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="dashboard-main">
            <h2 style="margin-bottom: 2rem;">Dashboard Overview</h2>
            
            <div class="dashboard-cards">
                <div class="stat-card">
                    <div class="stat-icon"><i data-lucide="shopping-bag"></i></div>
                    <div class="stat-info">
                        <h3><?= $totalOrders ?></h3>
                        <p>Total Orders</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon"><i data-lucide="clock"></i></div>
                    <div class="stat-info">
                        <h3><?= $pendingOrders ?></h3>
                        <p>Pending Orders</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon"><i data-lucide="check-circle"></i></div>
                    <div class="stat-info">
                        <h3><?= $deliveredOrders ?></h3>
                        <p>Delivered Orders</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon"><i data-lucide="heart"></i></div>
                    <div class="stat-info">
                        <h3><?= $wishlistCount ?></h3>
                        <p>Wishlist Items</p>
                    </div>
                </div>
            </div>
            
            <h3 style="margin-bottom: 1.5rem; margin-top: 3rem;">Recent Activity</h3>
            <p style="color: var(--muted);">No recent activity to show.</p>
            <!-- Here we could list the 3 most recent orders -->
            
        </main>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
