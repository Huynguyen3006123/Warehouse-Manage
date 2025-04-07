<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit();
}

// Kiểm tra MaNV
$MaNV = $_SESSION['MaNV'];

// Chuẩn bị truy vấn
$sql = "SELECT MaPN, MaNCC, NgayNhap, MaNV, TrangThai 
        FROM nhap 
        WHERE MaNV = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . $conn->error]);
    exit();
}

// Gán giá trị cho placeholder
$stmt->bind_param("s", $MaNV);

// Thực thi truy vấn
if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi thực thi truy vấn: ' . $stmt->error]);
    exit();
}

// Lấy kết quả
$result = $stmt->get_result();
$requests = [];

while ($row = $result->fetch_assoc()) {
    $requests[] = $row;
}


echo json_encode($requests);
// Đóng statement và kết nối
$stmt->close();
$conn->close();
?>