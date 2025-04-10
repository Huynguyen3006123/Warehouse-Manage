<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

if (!isset($_GET['MaPN'])) {
    echo json_encode(['success' => false, 'message' => 'Thiếu tham số MaPN']);
    exit();
}

$MaPN = $_GET['MaPN'];

// Truy vấn chỉ lấy các cột từ bảng ChiTietNhap và tính ThanhTien
$sql = "SELECT MaPN, MaSP, SoLuongNhap, GiaNhap, (SoLuongNhap * GiaNhap) AS ThanhTien
        FROM ChiTietNhap
        WHERE MaPN = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . $conn->error]);
    exit();
}

$stmt->bind_param("s", $MaPN);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

if (count($data) > 0) {
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => true, 'data' => []]); // Trả về mảng rỗng nếu không có dữ liệu
}

$stmt->close();
$conn->close();
?>