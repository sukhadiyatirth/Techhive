<?php
// index.php
require_once 'config/database.php';

$pageTitle = 'TechHive Electronic - Premium Technology';
include 'includes/header.php';

// Fetch Categories (limit 6)
$stmt = $pdo->query("SELECT * FROM categories WHERE status = 'active' LIMIT 6");
$categories = $stmt->fetchAll();

// Fetch Featured Products
$stmt = $pdo->query("
    SELECT p.*, b.name as brand_name 
    FROM products p 
    LEFT JOIN brands b ON p.brand_id = b.brand_id 
    WHERE p.status = 'active' AND p.featured = 1 
    LIMIT 8
");
$featuredProducts = $stmt->fetchAll();

// Fetch New Arrivals
$stmt = $pdo->query("
    SELECT p.*, b.name as brand_name 
    FROM products p 
    LEFT JOIN brands b ON p.brand_id = b.brand_id 
    WHERE p.status = 'active' AND p.new_arrival = 1 
    LIMIT 4
");
$newArrivals = $stmt->fetchAll();

// Fetch Best Sellers
$stmt = $pdo->query("
    SELECT p.*, b.name as brand_name 
    FROM products p 
    LEFT JOIN brands b ON p.brand_id = b.brand_id 
    WHERE p.status = 'active' AND p.bestseller = 1 
    LIMIT 4
");
$bestSellers = $stmt->fetchAll();

// Helper to render product cards
function renderProductCard($product) {
    $price = number_format($product['price'], 2);
    $discount = $product['discount_price'] ? number_format($product['discount_price'], 2) : null;
    $imgUrl = "assets/images/products/" . ($product['product_image'] ?: 'default.jpg');
    // Using a placeholder if image doesn't exist locally
    if (!file_exists($imgUrl)) {
        $imgUrl = "https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=400&q=80"; // fallback
    }

    echo '<div class="product-card animate-on-scroll">';
    echo '  <div class="product-badges">';
    if ($product['new_arrival']) echo '<span class="badge badge-new">New</span>';
    if ($product['bestseller']) echo '<span class="badge badge-bestseller">Best Seller</span>';
    if ($product['discount_percentage'] > 0) echo '<span class="badge badge-sale">-' . $product['discount_percentage'] . '%</span>';
    echo '  </div>';
    
    if (!isset($_SESSION['admin_id'])) {
        echo '  <button class="product-wishlist" aria-label="Add to wishlist" data-id="'.$product['product_id'].'"><i data-lucide="heart"></i></button>';
    }
    
    echo '  <a href="product.php?slug='.$product['slug'].'" class="product-image">';
    echo '    <img src="'.$imgUrl.'" alt="'.htmlspecialchars($product['product_name']).'">';
    echo '  </a>';
    
    echo '  <div class="product-brand">'.htmlspecialchars($product['brand_name'] ?? 'Unknown').'</div>';
    echo '  <a href="product.php?slug='.$product['slug'].'" class="product-title">'.htmlspecialchars($product['product_name']).'</a>';
    
    echo '  <div class="product-rating">';
    for ($i=1; $i<=5; $i++) {
        $fill = $i <= round($product['rating']) ? 'fill="currentColor"' : 'fill="none"';
        echo '<i data-lucide="star" class="icon-sm" '.$fill.'></i>';
    }
    echo '    <span>('.$product['review_count'].')</span>';
    echo '  </div>';
    
    echo '  <div class="product-price-row">';
    echo '    <div class="product-pricing">';
    if ($discount) {
        echo '      <span class="price">₹'.$discount.'</span>';
        echo '      <span class="price-original">₹'.$price.'</span>';
    } else {
        echo '      <span class="price">₹'.$price.'</span>';
    }
    echo '    </div>';
    if (!isset($_SESSION['admin_id'])) {
        echo '    <button class="btn-add-cart add-to-cart-btn" data-id="'.$product['product_id'].'" aria-label="Add to cart"><i data-lucide="shopping-bag"></i></button>';
    }
    echo '  </div>';
    echo '</div>';
}
?>

<!-- Hero Section -->
<section class="hero">
    <!-- Unsplash placeholder for premium tech background -->
    <img src="https://images.unsplash.com/photo-1550009158-9effb61970b5?auto=format&fit=crop&w=1920&q=80" alt="Premium Tech" class="hero-bg">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h1 class="hero-animate-title">Technology. Refined.</h1>
        <p class="hero-animate-text">Premium gadgets and accessories designed for the way you live, work and create.</p>
        <div class="hero-buttons hero-animate-btns">
            <a href="shop.php" class="btn btn-primary">Shop Collection</a>
            <a href="shop.php?filter=new" class="btn btn-outline">Explore New Arrivals</a>
        </div>
    </div>
</section>

<!-- Categories Showcase -->
<section class="section-padding container">
    <div class="section-header">
        <h2 class="section-title">Shop by Category</h2>
    </div>
    <div class="category-grid">
        <?php foreach ($categories as $cat): ?>
        <a href="shop.php?category=<?= $cat['slug'] ?>" class="category-card">
            <div class="category-icon">
                <!-- Using generic icons based on name, in a real app map slugs to specific lucide icons -->
                <i data-lucide="box" style="width:32px;height:32px;"></i>
            </div>
            <div class="category-name"><?= htmlspecialchars($cat['name']) ?></div>
        </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Featured Products -->
<?php if (count($featuredProducts) > 0): ?>
<section class="section-padding container">
    <div class="section-header">
        <h2 class="section-title">Curated For You</h2>
        <a href="shop.php" class="view-all">View All <i data-lucide="arrow-right" class="icon-sm"></i></a>
    </div>
    <div class="product-grid">
        <?php foreach ($featuredProducts as $product) renderProductCard($product); ?>
    </div>
</section>
<?php endif; ?>

<!-- Promotional Banner -->
<section class="container">
    <div class="promo-banner">
        <div class="promo-content">
            <h2 class="promo-title">Upgrade Your Setup</h2>
            <p class="promo-text">Premium accessories designed to enhance your workspace and boost your productivity.</p>
            <a href="shop.php?category=accessories" class="btn btn-primary">Explore Accessories</a>
        </div>
        <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=1000&q=80" alt="Workspace Setup" class="promo-image">
    </div>
</section>

<!-- New Arrivals -->
<?php if (count($newArrivals) > 0): ?>
<section class="section-padding container">
    <div class="section-header">
        <h2 class="section-title">New Arrivals</h2>
        <a href="shop.php?filter=new" class="view-all">View All <i data-lucide="arrow-right" class="icon-sm"></i></a>
    </div>
    <div class="product-grid">
        <?php foreach ($newArrivals as $product) renderProductCard($product); ?>
    </div>
</section>
<?php endif; ?>

<!-- Best Sellers -->
<?php if (count($bestSellers) > 0): ?>
<section class="section-padding container" style="margin-bottom: 4rem;">
    <div class="section-header">
        <h2 class="section-title">Best Sellers</h2>
        <a href="shop.php?filter=bestsellers" class="view-all">View All <i data-lucide="arrow-right" class="icon-sm"></i></a>
    </div>
    <div class="product-grid">
        <?php foreach ($bestSellers as $product) renderProductCard($product); ?>
    </div>
</section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
