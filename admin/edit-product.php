<?php
// Redirect dash version to underscore version
$id = $_GET['id'] ?? '';
header("Location: edit_product.php" . ($id ? "?id=" . urlencode($id) : ""));
exit();
?>
