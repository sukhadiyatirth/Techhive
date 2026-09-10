<?php
// product.php
require_once 'config/database.php';
require_once 'includes/functions.php';

$slug = $_GET['slug'] ?? '';
if (empty($slug)) {
    redirect('shop.php');
}

$product = getProductBySlug($pdo, $slug);

if (!$product) {
    // Product not found, maybe show a 404
    $pageTitle = 'Product Not Found - TechHive Electronic';
    include 'includes/header.php';
    echo '<div class="container section-padding" style="text-align: center; min-height: 60vh; display: flex; flex-direction: column; align-items: center; justify-content: center;">';
    echo '<h1 style="margin-bottom: 1rem;">Product Not Found</h1>';
    echo '<p style="color: var(--muted); margin-bottom: 2rem;">The product you are looking for does not exist or has been removed.</p>';
    echo '<a href="shop.php" class="btn btn-primary">Back to Shop</a>';
    echo '</div>';
    include 'includes/footer.php';
    exit();
}

$pageTitle = $product['product_name'] . ' - TechHive Electronic';
include 'includes/header.php';

$price = number_format($product['price'], 2);
$discount = $product['discount_price'] ? number_format($product['discount_price'], 2) : null;

// Images setup
$images = [];
if ($product['product_image']) $images[] = $product['product_image'];
if ($product['image_2']) $images[] = $product['image_2'];
if ($product['image_3']) $images[] = $product['image_3'];
if ($product['image_4']) $images[] = $product['image_4'];

if (empty($images)) {
    $images[] = 'default.jpg';
}

function getImageUrl($filename) {
    $path = "assets/images/products/" . $filename;
    if (!file_exists($path)) {
        return "https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=800&q=80";
    }
    return $path;
}

// Fetch Reviews
$stmt = $pdo->prepare("SELECT r.*, u.full_name FROM reviews r JOIN users u ON r.user_id = u.user_id WHERE r.product_id = ? AND r.status = 'approved' ORDER BY r.created_at DESC");
$stmt->execute([$product['product_id']]);
$reviews = $stmt->fetchAll();

// Fetch Related Products (same category)
$stmt = $pdo->prepare("SELECT p.*, b.name as brand_name FROM products p LEFT JOIN brands b ON p.brand_id = b.brand_id WHERE p.category_id = ? AND p.product_id != ? AND p.status = 'active' LIMIT 4");
$stmt->execute([$product['category_id'], $product['product_id']]);
$relatedProducts = $stmt->fetchAll();
?>

<div style="background: var(--surface); padding-top: 100px; padding-bottom: 1rem; border-bottom: 1px solid var(--border); margin-bottom: 3rem;">
    <div class="container">
        <div style="display: flex; gap: 0.5rem; color: var(--muted); font-size: 0.9rem;">
            <a href="index.php">Home</a> / 
            <a href="shop.php?category=<?= htmlspecialchars($product['category_name']) ?>"><?= htmlspecialchars($product['category_name']) ?></a> / 
            <span style="color: var(--text);"><?= htmlspecialchars($product['product_name']) ?></span>
        </div>
    </div>
</div>

<section class="container section-padding" style="padding-top: 0;">
    <div class="product-details">
        <!-- Gallery -->
        <div class="product-gallery">
            <div class="gallery-thumbnails">
                <?php foreach($images as $index => $img): ?>
                <div class="thumbnail <?= $index === 0 ? 'active' : '' ?>" onclick="changeMainImage(this, '<?= getImageUrl($img) ?>')">
                    <img src="<?= getImageUrl($img) ?>" alt="Thumbnail">
                </div>
                <?php endforeach; ?>
            </div>
            <div class="gallery-main">
                <img id="main-product-image" src="<?= getImageUrl($images[0]) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
            </div>
        </div>

        <!-- Info -->
        <div class="product-info">
            <div class="product-meta">
                <span class="product-brand"><?= htmlspecialchars($product['brand_name']) ?></span>
                <div class="product-rating">
                    <?php 
                    for ($i=1; $i<=5; $i++) {
                        $fill = $i <= round($product['rating']) ? 'fill="currentColor"' : 'fill="none"';
                        echo '<i data-lucide="star" class="icon-sm" style="color: var(--accent);" '.$fill.'></i>';
                    }
                    ?>
                    <span style="color: var(--muted); margin-left: 0.5rem;">(<?= count($reviews) ?> reviews)</span>
                </div>
            </div>
            
            <h1><?= htmlspecialchars($product['product_name']) ?></h1>
            <div class="sku">SKU: <?= htmlspecialchars($product['sku']) ?></div>
            
            <div class="product-pricing-large">
                <?php if ($discount): ?>
                    <span class="price">₹<?= $discount ?></span>
                    <span class="price-original" style="color: var(--muted); text-decoration: line-through;">₹<?= $price ?></span>
                    <span class="badge badge-sale" style="font-size: 0.9rem;">Save <?= $product['discount_percentage'] ?>%</span>
                <?php else: ?>
                    <span class="price">₹<?= $price ?></span>
                <?php endif; ?>
            </div>

            <p style="color: var(--muted); font-size: 1.1rem; margin-bottom: 2rem;">
                <?= htmlspecialchars($product['short_description']) ?>
            </p>

            <div class="stock-status <?= $product['stock_quantity'] > 0 ? 'in-stock' : 'out-of-stock' ?>">
                <i data-lucide="<?= $product['stock_quantity'] > 0 ? 'check-circle' : 'x-circle' ?>"></i>
                <?= $product['stock_quantity'] > 0 ? 'In Stock ('.$product['stock_quantity'].' available)' : 'Out of Stock' ?>
            </div>

            <?php if(!isset($_SESSION['admin_id'])): ?>
            <form action="cart_action.php" method="POST" class="product-actions">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                <input type="hidden" name="action" value="add">
                
                <div class="quantity-selector">
                    <button type="button" onclick="updateQty(-1)">-</button>
                    <input type="number" name="quantity" id="qty-input" value="1" min="1" max="<?= $product['stock_quantity'] ?>">
                    <button type="button" onclick="updateQty(1)">+</button>
                </div>
                
                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary" <?= $product['stock_quantity'] == 0 ? 'disabled' : '' ?>>
                        <i data-lucide="shopping-bag" style="margin-right: 0.5rem;"></i> Add to Cart
                    </button>
                    <button type="button" class="btn-wishlist" aria-label="Add to wishlist" onclick="addToWishlist(<?= $product['product_id'] ?>)">
                        <i data-lucide="heart"></i>
                    </button>
                </div>
            </form>
            <?php else: ?>
            <div style="padding: 1rem; background: var(--border); border-radius: 6px; color: var(--muted); margin-top: 1rem;">
                <i data-lucide="shield-alert" class="icon-sm"></i> Purchasing is disabled for Administrator accounts.
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabs -->
    <div class="product-tabs">
        <div class="tab-nav">
            <button class="active" onclick="switchTab(this, 'desc-tab')">Description</button>
            <button onclick="switchTab(this, 'specs-tab')">Specifications</button>
            <button onclick="switchTab(this, 'reviews-tab')">Reviews (<?= count($reviews) ?>)</button>
        </div>
        
        <div id="desc-tab" class="tab-content active" style="max-width: 800px; color: var(--muted); font-size: 1.1rem; line-height: 1.8;">
            <?= nl2br(htmlspecialchars($product['full_description'] ?? 'No description available.')) ?>
        </div>
        
        <div id="specs-tab" class="tab-content">
            <table class="spec-table">
                <tbody>
                    <tr>
                        <th>Brand</th>
                        <td><?= htmlspecialchars($product['brand_name']) ?></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td><?= htmlspecialchars($product['category_name']) ?></td>
                    </tr>
                    <tr>
                        <th>Warranty</th>
                        <td><?= htmlspecialchars($product['warranty'] ?? 'No Warranty') ?></td>
                    </tr>
                    <?php 
                    // Parse specifications if stored as JSON or simple text lines
                    if ($product['specifications']) {
                        $lines = explode("\n", $product['specifications']);
                        foreach($lines as $line) {
                            $parts = explode(":", $line, 2);
                            if (count($parts) == 2) {
                                echo '<tr><th>'.htmlspecialchars(trim($parts[0])).'</th><td>'.htmlspecialchars(trim($parts[1])).'</td></tr>';
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div id="reviews-tab" class="tab-content" style="max-width: 800px;">
            <?php if(empty($reviews)): ?>
                <p style="color: var(--muted);">No reviews yet. Be the first to review this product!</p>
            <?php else: ?>
                <?php foreach($reviews as $review): ?>
                <div style="border-bottom: 1px solid var(--border); padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <strong style="font-size: 1.1rem;"><?= htmlspecialchars($review['full_name']) ?></strong>
                        <span style="color: var(--muted); font-size: 0.9rem;"><?= date('M d, Y', strtotime($review['created_at'])) ?></span>
                    </div>
                    <div class="product-rating" style="margin-bottom: 1rem;">
                        <?php 
                        for ($i=1; $i<=5; $i++) {
                            $fill = $i <= $review['rating'] ? 'fill="currentColor"' : 'fill="none"';
                            echo '<i data-lucide="star" class="icon-sm" style="color: var(--accent);" '.$fill.'></i>';
                        }
                        ?>
                    </div>
                    <p style="color: var(--muted);"><?= nl2br(htmlspecialchars($review['review_text'])) ?></p>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Related Products -->
<?php if(count($relatedProducts) > 0): ?>
<section class="section-padding container">
    <div class="section-header">
        <h2 class="section-title">You Might Also Like</h2>
    </div>
    <div class="product-grid" style="grid-template-columns: repeat(4, 1fr);">
        <?php 
        // We'd ideally reuse renderProductCard here, since it's defined in index.php we can just redefine a simplified version or abstract it to functions.php
        // For now let's just abstract it properly in functions.php next step, or write the HTML inline.
        // I will write it inline for simplicity now to avoid modifying functions.php again for this small step.
        foreach($relatedProducts as $relProduct) {
            $rPrice = number_format($relProduct['price'], 2);
            $rImg = getImageUrl($relProduct['product_image'] ?: 'default.jpg');
            echo '<div class="product-card">';
            echo '  <a href="product.php?slug='.$relProduct['slug'].'" class="product-image"><img src="'.$rImg.'" alt=""></a>';
            echo '  <div class="product-brand">'.htmlspecialchars($relProduct['brand_name'] ?? '').'</div>';
            echo '  <a href="product.php?slug='.$relProduct['slug'].'" class="product-title">'.htmlspecialchars($relProduct['product_name']).'</a>';
            echo '  <div class="product-price-row">';
            echo '    <span class="price">₹'.$rPrice.'</span>';
            echo '  </div>';
            echo '</div>';
        }
        ?>
    </div>
</section>
<?php endif; ?>

<script>
function changeMainImage(thumb, src) {
    document.getElementById('main-product-image').src = src;
    document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
}

function updateQty(change) {
    const input = document.getElementById('qty-input');
    let val = parseInt(input.value) + change;
    if (val >= parseInt(input.min) && val <= parseInt(input.max)) {
        input.value = val;
    }
}

function switchTab(btn, tabId) {
    document.querySelectorAll('.tab-nav button').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
    
    btn.classList.add('active');
    document.getElementById(tabId).classList.add('active');
}

function addToWishlist(productId) {
    // Will be implemented in wishlist stage
    alert('Wishlist feature coming soon!');
}
</script>

<?php include 'includes/footer.php'; ?>
