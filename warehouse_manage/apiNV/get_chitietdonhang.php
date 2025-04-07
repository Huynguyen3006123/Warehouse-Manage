<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

session_start();
if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
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
    $details[] = [
        'MaPX' => (int)$row['MaPX'],          // Ép thành integer
        'MaSP' => (int)$row['MaSP'],          // Ép thành integer
        'TenSP' => $row['TenSP'],             // Giữ nguyên string
        'SoLuongXuat' => (int)$row['SoLuongXuat'], // Ép thành integer
        'DonGia' => (float)$row['DonGia'],    // Ép thành float vì có thể có phần thập phân
        'ThanhTien' => (float)$row['ThanhTien']
    ];
}

if (empty($details)) {
    echo json_encode(['success' => true, 'data' => [], 'message' => 'Không có chi tiết cho phiếu xuất này']);
} else {
    echo json_encode(['success' => true, 'data' => $details]);
}

$stmt->close();
$conn->close();
?>