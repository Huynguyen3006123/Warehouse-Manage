<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

session_start();
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] !== "Quản lý") {
    echo json_encode(['success' => false, 'message' => 'Không có quyền truy cập']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
    exit();
}

$MaPX = $_POST['MaPX'] ?? '';
$NgayXuat = $_POST['NgayXuat'] ?? '';
$MaNV = $_SESSION['MaNV'] ?? ''; // Lấy từ session

if (empty($MaPX) || empty($NgayXuat) || empty($MaNV)) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin: MaPX, NgayXuat hoặc MaNV']);
    exit();
}

$sql = "UPDATE xuat SET TrangThai = 'confirmed', NgayXuat = ?, MaNV = ? WHERE MaPX = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . $conn->error]);
    exit();
}

$stmt->bind_param("sss", $NgayXuat, $MaNV, $MaPX);
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Phiếu xuất đã được duyệt']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy phiếu xuất để duyệt']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi duyệt phiếu xuất: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>