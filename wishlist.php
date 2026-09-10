<?php
// wishlist.php
require_once 'includes/auth.php'; // Require login
require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'My Wishlist - TechHive Electronic';
include 'includes/header.php';

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT p.*, w.wishlist_id, b.name as brand_name 
    FROM wishlist w 
    JOIN products p ON w.product_id = p.product_id 
    LEFT JOIN brands b ON p.brand_id = b.brand_id 
    WHERE w.user_id = ?
    ORDER BY w.created_at DESC
");
$stmt->execute([$userId]);
$wishlistItems = $stmt->fetchAll();

// Product Card Helper logic is duplicated, but fine for this scope.
function renderWishlistCard($product) {
    $price = number_format($product['price'], 2);
    $discount = $product['discount_price'] ? number_format($product['discount_price'], 2) : null;
    $imgUrl = "assets/images/products/" . ($product['product_image'] ?: 'default.jpg');
    if (!file_exists($imgUrl)) {
        $imgUrl = "https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=400&q=80"; // fallback
    }

    echo '<div class="product-card">';
    echo '  <form action="wishlist_action.php" method="POST" style="position: absolute; top: 1rem; right: 1rem; z-index: 10;">';
    echo '      <input type="hidden" name="action" value="remove">';
    echo '      <input type="hidden" name="product_id" value="'.$product['product_id'].'">';
    echo '      <button type="submit" class="product-wishlist" style="color: var(--error);" aria-label="Remove from wishlist"><i data-lucide="trash-2"></i></button>';
    echo '  </form>';
    
    echo '  <a href="product.php?slug='.$product['slug'].'" class="product-image">';
    echo '    <img src="'.$imgUrl.'" alt="'.htmlspecialchars($product['product_name']).'">';
    echo '  </a>';
    
    echo '  <div class="product-brand">'.htmlspecialchars($product['brand_name'] ?? 'Unknown').'</div>';
    echo '  <a href="product.php?slug='.$product['slug'].'" class="product-title">'.htmlspecialchars($product['product_name']).'</a>';
    
    echo '  <div class="product-price-row">';
    echo '    <div class="product-pricing">';
    if ($discount) {
        echo '      <span class="price">$'.$discount.'</span>';
        echo '      <span class="price-original">$'.$price.'</span>';
    } else {
        echo '      <span class="price">$'.$price.'</span>';
    }
    echo '    </div>';
    
    echo '    <form action="cart_action.php" method="POST">';
    echo '      <input type="hidden" name="action" value="add">';
    echo '      <input type="hidden" name="product_id" value="'.$product['product_id'].'">';
    echo '      <input type="hidden" name="quantity" value="1">';
    echo '      <button type="submit" class="btn-add-cart add-to-cart-btn" aria-label="Add to cart"><i data-lucide="shopping-bag"></i></button>';
    echo '    </form>';
    
    echo '  </div>';
    echo '</div>';
}
?>

<div style="background: var(--surface); padding-top: 100px; padding-bottom: 2rem; border-bottom: 1px solid var(--border); margin-bottom: 3rem;">
    <div class="container">
        <h1 style="font-size: 2.5rem; letter-spacing: -0.03em;">My Wishlist</h1>
    </div>
</div>

<section class="container section-padding" style="padding-top: 0;">
    <?php if (empty($wishlistItems)): ?>
        <div style="text-align: center; padding: 4rem 0;">
            <i data-lucide="heart" style="width: 64px; height: 64px; color: var(--muted); margin-bottom: 1rem;"></i>
            <h2>Save the products you love.</h2>
            <p style="color: var(--muted); margin-bottom: 2rem;">Your wishlist is currently empty.</p>
            <a href="shop.php" class="btn btn-primary">Discover Products</a>
        </div>
    <?php else: ?>
        <div class="product-grid" style="grid-template-columns: repeat(4, 1fr);">
            <?php foreach ($wishlistItems as $product) renderWishlistCard($product); ?>
        </div>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
