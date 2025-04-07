<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

if (!isset($_GET['type'])) {
    echo json_encode(['success' => false, 'message' => 'Thiếu tham số type']);
    exit();
}

$type = $_GET['type'];
$table = '';
$column = '';

if ($type === 'PhieuNhap') {
    $table = 'nhap';
    $column = 'MaPN';
} else {
    echo json_encode(['success' => false, 'message' => 'Loại mã không hợp lệ']);
    exit();
}

// Lấy mã cuối cùng từ cơ sở dữ liệu
$sql = "SELECT $column FROM $table ORDER BY $column DESC LIMIT 1";
$result = $conn->query($sql);

if ($result === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn: ' . $conn->error]);
    exit();
}

if ($result->num_rows > 0) {
    $lastMa = $result->fetch_assoc()[$column];
    $newMa = (int)$lastMa + 1; // Tăng số lên 1
} else {
    $newMa = 1; // Nếu không có mã nào, bắt đầu từ 1
}

echo json_encode(['success' => true, $column => $newMa]);

$conn->close();
?>