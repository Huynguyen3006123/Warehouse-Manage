
<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

// Bắt đầu session để kiểm tra vai trò người dùng
session_start();

// Kiểm tra vai trò người dùng (giả sử Role được lưu trong session)
$isAdmin = isset($_SESSION['Role']) && $_SESSION['Role'] === 'Quản Lý';

// Xử lý tham số status từ URL
$statusFilter = '';
if (isset($_GET['status']) && $_GET['status'] === 'show') {
    // Nếu có tham số status=show (dành cho nhân viên), chỉ lấy sản phẩm có TrangThai = 'show'
    $statusFilter = "WHERE TrangThai = 'show'";
} elseif (!$isAdmin) {
    // Nếu không phải admin và không có tham số status, mặc định chỉ lấy sản phẩm có TrangThai = 'show' (dành cho nhân viên)
    $statusFilter = "WHERE TrangThai = 'show'";
} else {
    // Nếu là admin và không có tham số status, lấy tất cả sản phẩm (bao gồm cả show và hide)
    $statusFilter = "";
}

$sql = "SELECT MaSP, TenSP, LoaiSP, KichCo, MauSac, GiaNhap, GiaXuat, SoLuongTon, NgayNhap, TrangThai
        FROM sanpham $statusFilter";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . $conn->error]);
    exit();
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>