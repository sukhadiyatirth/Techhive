<?php
// admin/includes/sidebar.php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<aside class="admin-sidebar">
    <div class="sidebar-brand">
        TechHive<span>.</span> Admin
    </div>
    <ul class="sidebar-menu">
        <li><a href="index.php" class="<?= $currentPage == 'index.php' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="orders.php" class="<?= $currentPage == 'orders.php' ? 'active' : '' ?>">Orders</a></li>
        <li><a href="products.php" class="<?= strpos($currentPage, 'product') !== false ? 'active' : '' ?>">Products</a></li>
        <li><a href="categories.php" class="<?= $currentPage == 'categories.php' ? 'active' : '' ?>">Categories</a></li>
        <li><a href="brands.php" class="<?= $currentPage == 'brands.php' ? 'active' : '' ?>">Brands</a></li>
        <li><a href="customers.php" class="<?= $currentPage == 'customers.php' ? 'active' : '' ?>">Customers</a></li>
        <li><a href="coupons.php" class="<?= $currentPage == 'coupons.php' ? 'active' : '' ?>">Coupons</a></li>
        <li><a href="../index.php" target="_blank">View Website</a></li>
        <li><a href="logout.php" style="color: var(--error);">Logout</a></li>
    </ul>
</aside>
