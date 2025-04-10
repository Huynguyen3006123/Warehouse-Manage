
<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

session_start();
if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit();
}

$sql = "SELECT MaSP, TenSP, LoaiSP, KichCo, MauSac, GiaNhap, GiaXuat, SoLuongTon 
        FROM sanpham WHERE TrangThai = 'show'";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . $conn->error]);
    exit();
}

$stmt->execute();
$result = $stmt->get_result();
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products); // Trả về mảng sản phẩm trực tiếp

$stmt->close();
$conn->close();
?>