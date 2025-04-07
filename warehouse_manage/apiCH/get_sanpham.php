<?php
header("Content-Type: application/json; charset=UTF-8");
require '../api/db.php'; // Đảm bảo đường dẫn đúng

// Kiểm tra kết nối cơ sở dữ liệu
if (!$conn) {
    error_log("Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error);
    echo json_encode(['success' => false, 'message' => 'Lỗi kết nối cơ sở dữ liệu']);
    exit();
}

$status = $_GET['status'] ?? '';

// Truy vấn SQL (bỏ minStock, giữ SoLuongTon > 0)
$sql = "SELECT MaSP, TenSP, LoaiSP, KichCo, MauSac, GiaXuat, SoLuongTon 
        FROM sanpham 
        WHERE TrangThai = ? AND SoLuongTon > 0";
$stmt = $conn->prepare($sql);

// Kiểm tra lỗi khi chuẩn bị truy vấn
if (!$stmt) {
    error_log("Lỗi chuẩn bị truy vấn: " . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn cơ sở dữ liệu']);
    exit();
}

// Bind tham số (chỉ còn $status)
$stmt->bind_param('s', $status);

// Thực thi truy vấn
if (!$stmt->execute()) {
    error_log("Lỗi thực thi truy vấn: " . $stmt->error);
    echo json_encode(['success' => false, 'message' => 'Lỗi thực thi truy vấn']);
    $stmt->close();
    $conn->close();
    exit();
}

$result = $stmt->get_result();
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Trả về dữ liệu dưới dạng JSON
echo json_encode($products);

// Đóng statement và kết nối
$stmt->close();
$conn->close();
?>