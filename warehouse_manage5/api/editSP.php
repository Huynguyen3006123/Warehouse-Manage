<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maSP = $_POST['MaSP'];
    $tenSP = $_POST['TenSP'];
    $loaiSP = $_POST['LoaiSP'];
    $kichCo = $_POST['KichCo'];
    $mauSac = $_POST['MauSac'];
    $giaNhap = $_POST['GiaNhap'];
    $giaXuat = $_POST['GiaXuat'];
    // Không lấy SoLuongTon vì không cho sửa

    $sql = "UPDATE sanpham SET TenSP = ?, LoaiSP = ?, KichCo = ?, MauSac = ?, GiaNhap = ?, GiaXuat = ? WHERE MaSP = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssddi", $tenSP, $loaiSP, $kichCo, $mauSac, $giaNhap, $giaXuat, $maSP);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Cập nhật sản phẩm thành công"]);
    } else {
        echo json_encode(["error" => "Lỗi khi cập nhật sản phẩm"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Phương thức không hợp lệ"]);
}

$conn->close();
?>