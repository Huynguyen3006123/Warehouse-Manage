<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

session_start();
if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit();
}

// Lấy MaNV từ session thay vì từ GET
$MaNV = $_SESSION['MaNV'];

$sql = "SELECT MaPX, NgayXuat, MaNV, MaCH, MaHoaDon 
        FROM xuat 
        WHERE MaNV = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . $conn->error]);
    exit();
}

$stmt->bind_param("s", $MaNV);
$stmt->execute();
$result = $stmt->get_result();
$exports = [];

while ($row = $result->fetch_assoc()) {
    $exports[] = $row;
}

echo json_encode(['success' => true, 'data' => $exports]);

$stmt->close();
$conn->close();
?>