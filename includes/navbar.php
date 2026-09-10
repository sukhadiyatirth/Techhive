<?php
// includes/navbar.php
$cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
// If user is logged in, you could also fetch the count from the database
?>
<header class="site-header">
    <div class="header-container">
        <!-- Logo -->
        <a href="index.php" class="logo">
            TechHive<span>.</span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="desktop-nav">
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li class="dropdown">
                    <a href="shop.php">Categories <i data-lucide="chevron-down" class="icon-sm"></i></a>
                    <div class="dropdown-menu">
                        <a href="shop.php?category=laptops">Laptops</a>
                        <a href="shop.php?category=earbuds">Earbuds</a>
                        <a href="shop.php?category=smart-watches">Smart Watches</a>
                        <a href="shop.php?category=accessories">Accessories</a>
                    </div>
                </li>
                <li><a href="shop.php?filter=new">New Arrivals</a></li>
                <li><a href="shop.php?filter=bestsellers">Best Sellers</a></li>
                <li><a href="about.php">About</a></li>
                <?php if(isset($_SESSION['admin_id'])): ?>
                    <li><a href="admin/index.php" style="color: var(--accent); font-weight: 600;">Admin Panel <i data-lucide="shield" class="icon-sm"></i></a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Right Icons -->
        <div class="header-icons">
            <button class="icon-btn search-toggle" aria-label="Search">
                <i data-lucide="search"></i>
            </button>
            <?php if (!isset($_SESSION['admin_id'])): ?>
                <a href="wishlist.php" class="icon-btn" aria-label="Wishlist">
                    <i data-lucide="heart"></i>
                </a>
            <?php endif; ?>
            <div class="account-dropdown">
                <?php
                $accountLink = 'login.php';
                if (isset($_SESSION['admin_id'])) {
                    $accountLink = 'admin/index.php';
                } elseif (isset($_SESSION['user_id'])) {
                    $accountLink = 'profile.php';
                }
                ?>
                <a href="<?= $accountLink ?>" class="icon-btn" aria-label="Account">
                    <i data-lucide="user"></i>
                </a>
            </div>
            <?php if (!isset($_SESSION['admin_id'])): ?>
                <a href="cart.php" class="icon-btn cart-btn" aria-label="Cart">
                    <i data-lucide="shopping-cart"></i>
                    <span class="cart-count"><?= $cartCount ?></span>
                </a>
            <?php endif; ?>
            <button class="icon-btn mobile-menu-toggle d-mobile" aria-label="Menu">
                <i data-lucide="menu"></i>
            </button>
        </div>
    </div>
    
    <!-- Search Overlay -->
    <div class="search-overlay">
        <div class="search-container">
            <form action="shop.php" method="GET" class="search-form">
                <i data-lucide="search" class="search-icon"></i>
                <input type="text" name="q" placeholder="Search for premium tech..." autofocus>
                <button type="button" class="close-search"><i data-lucide="x"></i></button>
            </form>
            <div class="search-suggestions"></div>
        </div>
    </div>
</header>
