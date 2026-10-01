<?php
// search.php - Redirect search query to shop.php search handler
$q = $_GET['q'] ?? '';
if (!empty($q)) {
    header("Location: shop.php?q=" . urlencode($q));
} else {
    header("Location: shop.php");
}
exit();
?>
