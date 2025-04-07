<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

if (!isset($_SESSION['UserID']) || $_SESSION['Role'] !== 'Cửa Hàng') {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập hoặc không có quyền']);
    exit();
}

$cart = $_SESSION['cart'] ?? [];
echo json_encode(['success' => true, 'data' => $cart]);
?>