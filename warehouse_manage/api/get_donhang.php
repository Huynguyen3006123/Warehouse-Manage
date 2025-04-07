<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php'; // Đảm bảo đường dẫn đúng

session_start();
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] !== "Quản lý") {
    echo json_encode(['success' => false, 'message' => 'Không có quyền truy cập']);
    exit();
}

$sql = "SELECT MaPX, MaCH, NgayXuat, TrangThai 
        FROM xuat 
        WHERE TrangThai = 'pending'";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . $conn->error]);
    exit();
}

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