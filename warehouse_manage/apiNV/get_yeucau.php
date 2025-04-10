<?php
header("Content-Type: application/json; charset=UTF-8");
session_start(); // Bắt đầu session để truy cập $_SESSION
include 'db.php';

// Lấy MaNV từ session
$MaNV = isset($_SESSION['MaNV']) ? $_SESSION['MaNV'] : null;

if (!$MaNV) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy MaNV trong session. Vui lòng đăng nhập lại.']);
    exit();
}

$sql = "SELECT n.MaPN, ncc.TenNCC, n.NgayNhap, nv.HoTen, n.TrangThai
        FROM nhap n
        LEFT JOIN ncc ON n.MaNCC = ncc.MaNCC
        LEFT JOIN nhanvien nv ON n.MaNV = nv.MaNV 
        WHERE n.MaNV = ?";

// Chuẩn bị truy vấn
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . $conn->error]);
    exit();
}

// Gán tham số và thực thi
$stmt->bind_param("s", $MaNV);
if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi thực thi truy vấn: ' . $stmt->error]);
    exit();
}

// Gán kết quả vào biến
$stmt->bind_result($maPN, $tenNCC, $ngayNhap, $hoTen, $TrangThai);

$data = [];
while ($stmt->fetch()) {
    $data[] = [
        'MaPN' => $maPN,
        'TenNCC' => $tenNCC,
        'NgayNhap' => $ngayNhap,
        'HoTen' => $hoTen,
        'TrangThai' => $TrangThai
    ];
}

echo json_encode($data);

// Đóng statement và kết nối
$stmt->close();
$conn->close();
?>