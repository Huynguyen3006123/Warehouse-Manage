<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();
require 'db.php';

if (!isset($_SESSION['MaCH'])) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy mã cửa hàng']);
    exit();
}

$maCH = $_SESSION['MaCH'];
$stmt = $conn->prepare("SELECT MaPX, NgayXuat, TrangThai FROM xuat WHERE MaCH = ?");
$stmt->bind_param("s", $maCH);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);

$stmt->close();
$conn->close();
?>