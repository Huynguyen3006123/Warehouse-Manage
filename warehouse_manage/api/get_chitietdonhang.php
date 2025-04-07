<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php'; // Đảm bảo đường dẫn đúng

session_start();
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] !== "Quản lý") {
    echo json_encode(['success' => false, 'message' => 'Không có quyền truy cập']);
    exit();
}

$MaPX = $_GET['MaPX'] ?? '';
if (empty($MaPX)) {
    echo json_encode(['success' => false, 'message' => 'Thiếu mã phiếu xuất']);
    exit();
}

$sql = "SELECT c.MaPX, c.MaSP, s.TenSP, c.SoLuongXuat, c.DonGia, c.ThanhTien 
        FROM chitietxuat c 
        JOIN sanpham s ON c.MaSP = s.MaSP 
        WHERE c.MaPX = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . $conn->error]);
    exit();
}

$stmt->bind_param("s", $MaPX);
$stmt->execute();
$result = $stmt->get_result();
$details = [];

while ($row = $result->fetch_assoc()) {
    $details[] = $row;
}

if (empty($details)) {
    echo json_encode(['success' => true, 'data' => [], 'message' => 'Không có chi tiết cho phiếu xuất này']);
} else {
    echo json_encode(['success' => true, 'data' => $details]);
}

$stmt->close();
$conn->close();
?>