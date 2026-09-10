<?php
// shop.php
require_once 'config/database.php';

$pageTitle = 'Shop Premium Tech - TechHive Electronic';
include 'includes/header.php';

// Pagination setup
$limit = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Filter setup
$whereClauses = ["p.status = 'active'"];
$params = [];

// Category filter
if (!empty($_GET['category'])) {
    $whereClauses[] = "c.slug = ?";
    $params[] = $_GET['category'];
}

// Brand filter
if (!empty($_GET['brand'])) {
    $whereClauses[] = "b.slug = ?";
    $params[] = $_GET['brand'];
}

// Search Query filter
if (!empty($_GET['q'])) {
    $whereClauses[] = "(p.product_name LIKE ? OR p.short_description LIKE ? OR b.name LIKE ? OR c.name LIKE ?)";
    $searchTerm = '%' . $_GET['q'] . '%';
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

// Special filters (new, bestsellers)
if (!empty($_GET['filter'])) {
    if ($_GET['filter'] == 'new') {
        $whereClauses[] = "p.new_arrival = 1";
    } elseif ($_GET['filter'] == 'bestsellers') {
        $whereClauses[] = "p.bestseller = 1";
    }
}

// Sorting setup
$sort = $_GET['sort'] ?? 'newest';
$orderBy = "p.created_at DESC";
switch ($sort) {
    case 'price_low':
        $orderBy = "COALESCE(p.discount_price, p.price) ASC";
        break;
    case 'price_high':
        $orderBy = "COALESCE(p.discount_price, p.price) DESC";
        break;
    case 'rating':
        $orderBy = "p.rating DESC";
        break;
}

$whereSql = implode(' AND ', $whereClauses);

// Fetch Total count for pagination
$countSql = "SELECT COUNT(*) FROM products p 
             LEFT JOIN categories c ON p.category_id = c.category_id 
             LEFT JOIN brands b ON p.brand_id = b.brand_id 
             WHERE $whereSql";
$stmt = $pdo->prepare($countSql);
$stmt->execute($params);
$totalProducts = $stmt->fetchColumn();
$totalPages = ceil($totalProducts / $limit);

// Fetch Products
$sql = "SELECT p.*, b.name as brand_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.category_id 
        LEFT JOIN brands b ON p.brand_id = b.brand_id 
        WHERE $whereSql 
        ORDER BY $orderBy 
        LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Fetch Categories for Sidebar
$stmt = $pdo->query("SELECT name, slug FROM categories WHERE status = 'active' ORDER BY name ASC");
$categories = $stmt->fetchAll();

// Fetch Brands for Sidebar
$stmt = $pdo->query("SELECT name, slug FROM brands WHERE status = 'active' ORDER BY name ASC");
$brands = $stmt->fetchAll();

// Product Card Helper (Reused from index.php logic, normally put in functions.php)
function renderShopProductCard($product) {
    $price = number_format($product['price'], 2);
    $discount = $product['discount_price'] ? number_format($product['discount_price'], 2) : null;
    $imgUrl = "assets/images/products/" . ($product['product_image'] ?: 'default.jpg');
    if (!file_exists($imgUrl)) {
        $imgUrl = "https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=400&q=80"; // fallback
    }

    echo '<div class="product-card animate-on-scroll">';
    echo '  <div class="product-badges">';
    if ($product['new_arrival']) echo '<span class="badge badge-new">New</span>';
    if ($product['bestseller']) echo '<span class="badge badge-bestseller">Best</span>';
    if ($product['discount_percentage'] > 0) echo '<span class="badge badge-sale">-' . $product['discount_percentage'] . '%</span>';
    echo '  </div>';
    if (!isset($_SESSION['admin_id'])) {
        echo '  <button class="product-wishlist" aria-label="Add to wishlist"><i data-lucide="heart"></i></button>';
    }
    echo '  <a href="product.php?slug='.$product['slug'].'" class="product-image"><img src="'.$imgUrl.'" alt=""></a>';
    echo '  <div class="product-brand">'.htmlspecialchars($product['brand_name'] ?? '').'</div>';
    echo '  <a href="product.php?slug='.$product['slug'].'" class="product-title">'.htmlspecialchars($product['product_name']).'</a>';
    echo '  <div class="product-rating">';
    for ($i=1; $i<=5; $i++) {
        $fill = $i <= round($product['rating']) ? 'fill="currentColor"' : 'fill="none"';
        echo '<i data-lucide="star" class="icon-sm" '.$fill.'></i>';
    }
    echo '  </div>';
    echo '  <div class="product-price-row">';
    echo '    <div class="product-pricing">';
    if ($discount) {
        echo '      <span class="price">₹'.$discount.'</span> <span class="price-original">₹'.$price.'</span>';
    } else {
        echo '      <span class="price">₹'.$price.'</span>';
    }
    echo '    </div>';
    if (!isset($_SESSION['admin_id'])) {
        echo '    <button class="btn-add-cart"><i data-lucide="shopping-bag"></i></button>';
    }
    echo '  </div>';
    echo '</div>';
}
?>

<div style="background: var(--surface); padding-top: 100px; padding-bottom: 2rem; border-bottom: 1px solid var(--border);">
    <div class="container">
        <?php if(!empty($_GET['q'])): ?>
            <h1 style="font-size: 2.5rem; letter-spacing: -0.03em;">Search Results for "<span style="color: var(--accent);"><?= htmlspecialchars($_GET['q']) ?></span>"</h1>
            <p style="color: var(--muted); margin-top: 0.5rem;">Found <?= $totalItems ?> items matching your search.</p>
        <?php else: ?>
            <h1 style="font-size: 2.5rem; letter-spacing: -0.03em;">Shop Premium Tech</h1>
            <p style="color: var(--muted); margin-top: 0.5rem;">Explore our curated collection of luxury electronics.</p>
        <?php endif; ?>
    </div>
</div>

<section class="section-padding container">
    <div class="shop-layout">
        <!-- Sidebar -->
        <aside class="shop-sidebar" style="position: sticky; top: 120px; max-height: calc(100vh - 140px); overflow-y: auto;">
            <form action="shop.php" method="GET" id="filter-form">
                <?php if(!empty($_GET['q'])): ?>
                    <input type="hidden" name="q" value="<?= htmlspecialchars($_GET['q']) ?>">
                <?php endif; ?>
                
                <div class="filter-group">
                    <h3>Categories</h3>
                    <ul class="filter-list">
                        <li>
                            <label>
                                <input type="radio" name="category" value="" onchange="this.form.submit()" <?= empty($_GET['category']) ? 'checked' : '' ?>>
                                All Categories
                            </label>
                        </li>
                        <?php foreach($categories as $cat): ?>
                        <li>
                            <label>
                                <input type="radio" name="category" value="<?= $cat['slug'] ?>" onchange="this.form.submit()" <?= (isset($_GET['category']) && $_GET['category'] == $cat['slug']) ? 'checked' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </label>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="filter-group">
                    <h3>Brands</h3>
                    <ul class="filter-list">
                        <li>
                            <label>
                                <input type="radio" name="brand" value="" onchange="this.form.submit()" <?= empty($_GET['brand']) ? 'checked' : '' ?>>
                                All Brands
                            </label>
                        </li>
                        <?php foreach($brands as $brand): ?>
                        <li>
                            <label>
                                <input type="radio" name="brand" value="<?= $brand['slug'] ?>" onchange="this.form.submit()" <?= (isset($_GET['brand']) && $_GET['brand'] == $brand['slug']) ? 'checked' : '' ?>>
                                <?= htmlspecialchars($brand['name']) ?>
                            </label>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <!-- Hidden Sort input to persist sorting when filtering -->
                <input type="hidden" name="sort" id="sort-hidden" value="<?= htmlspecialchars($sort) ?>">
            </form>
        </aside>

        <!-- Main Content -->
        <main class="shop-main">
            <div class="shop-topbar">
                <div class="shop-results-count">
                    Showing <?= min($offset + 1, $totalProducts) ?>-<?= min($offset + $limit, $totalProducts) ?> of <?= $totalProducts ?> results
                </div>
                <div class="shop-sorting">
                    <select onchange="document.getElementById('sort-hidden').value=this.value; document.getElementById('filter-form').submit();">
                        <option value="newest" <?= $sort == 'newest' ? 'selected' : '' ?>>Newest Arrivals</option>
                        <option value="price_low" <?= $sort == 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_high" <?= $sort == 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                        <option value="rating" <?= $sort == 'rating' ? 'selected' : '' ?>>Highest Rated</option>
                    </select>
                </div>
            </div>

            <?php if ($totalProducts > 0): ?>
                <div class="product-grid" style="grid-template-columns: repeat(3, 1fr);">
                    <?php foreach ($products as $product) renderShopProductCard($product); ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php for($i=1; $i<=$totalPages; $i++): ?>
                        <?php 
                        $queryArgs = $_GET;
                        $queryArgs['page'] = $i;
                        $queryString = http_build_query($queryArgs);
                        ?>
                        <a href="?<?= $queryString ?>" class="page-btn <?= $page == $i ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
                
            <?php else: ?>
                <div style="text-align: center; padding: 4rem 0;">
                    <i data-lucide="search-x" style="width: 64px; height: 64px; color: var(--muted); margin-bottom: 1rem;"></i>
                    <h2>No products found</h2>
                    <p style="color: var(--muted); margin-bottom: 2rem;">Try adjusting your filters or search query.</p>
                    <a href="shop.php" class="btn btn-primary">Clear Filters</a>
                </div>
            <?php endif; ?>
        </main>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
