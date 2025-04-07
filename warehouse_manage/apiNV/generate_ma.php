<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

if (!isset($_GET['type'])) {
    echo json_encode(['success' => false, 'message' => 'Thiếu tham số type']);
    exit();
}

$type = $_GET['type'];
$prefix = '';
$table = '';
$column = '';

if ($type === 'PhieuNhap') {
    $prefix = 'PN';
    $table = 'nhap';
    $column = 'MaPN';
} elseif ($type === 'HoaDon') {
    $prefix = 'HD';
    $table = 'hoadon';
    $column = 'MaHoaDon';
} else {
    echo json_encode(['success' => false, 'message' => 'Loại mã không hợp lệ']);
    exit();
}

// Lấy mã cuối cùng từ cơ sở dữ liệu
$sql = "SELECT $column FROM $table ORDER BY $column DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $lastMa = $result->fetch_assoc()[$column];
    $number = (int) substr($lastMa, 2) + 1;
} else {
    $number = 1;
}

$newMa = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT); // Ví dụ: PN001, HD001

echo json_encode(['success' => true, $column => $newMa]);

$conn->close();
?>