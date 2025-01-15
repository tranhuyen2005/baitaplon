<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if ($id !== null) {
    $stmt = $conn->prepare("DELETE FROM tiendichvu WHERE id = ?");
    $stmt->execute([$id]);
}

// Quay về trang chính
header("Location: dichvu.php");
exit;
?>
