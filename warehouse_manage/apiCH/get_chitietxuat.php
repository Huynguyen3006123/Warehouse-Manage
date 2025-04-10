<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php'; // Đảm bảo đường dẫn đúng

// Kiểm tra kết nối cơ sở dữ liệu
if (!$conn) {
    error_log("Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error);
    echo json_encode(['success' => false, 'message' => 'Lỗi kết nối cơ sở dữ liệu']);
    exit();
}

$maPX = $_GET['MaPX'] ?? '';

// Kiểm tra dữ liệu đầu vào
if (empty($maPX)) {
    echo json_encode(['success' => false, 'message' => 'Mã phiếu xuất không hợp lệ']);
    exit();
}

// Chuẩn bị truy vấn
$stmt = $conn->prepare("SELECT ct.MaPX, ct.MaSP, sp.TenSP, ct.SoLuongXuat, ct.DonGia, ct.ThanhTien 
                        FROM chitietxuat ct 
                        JOIN sanpham sp ON ct.MaSP = sp.MaSP 
                        WHERE ct.MaPX = ?");
if (!$stmt) {
    error_log("Lỗi chuẩn bị truy vấn: " . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn cơ sở dữ liệu']);
    exit();
}

// Bind tham số và thực thi
$stmt->bind_param("s", $maPX);
if (!$stmt->execute()) {
    error_log("Lỗi thực thi truy vấn: " . $stmt->error);
    echo json_encode(['success' => false, 'message' => 'Lỗi thực thi truy vấn']);
    $stmt->close();
    $conn->close();
    exit();
}

$result = $stmt->get_result();
$details = [];
while ($row = $result->fetch_assoc()) {
    $details[] = $row;
}

// Trả về dữ liệu với JSON_NUMERIC_CHECK
echo json_encode(['success' => true, 'data' => $details], JSON_NUMERIC_CHECK);

// Đóng statement và kết nối
$stmt->close();
$conn->close();
?>