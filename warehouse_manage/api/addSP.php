<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSP = $_POST['MaSP'] ?? '';
    $TenSP = $_POST['TenSP'] ?? '';
    $LoaiSP = $_POST['LoaiSP'] ?? '';
    $MauSac = $_POST['MauSac'] ?? '';
    $SoLuongTon = 0;
    $GiaNhap = $_POST['GiaNhap'] ?? 0;
    $GiaXuat = $_POST['GiaXuat'] ?? 0;

    if (empty($MaSP) || empty($TenSP)) {
        echo "Thiếu thông tin sản phẩm!";
        exit;
    }

    $NgayNhap = date('Y-m-d'); // Get the current date in 'YYYY-MM-DD' format

    $stmt = $conn->prepare("INSERT INTO sanpham (MaSP, TenSP, LoaiSP, MauSac, SoLuongTon, GiaNhap, GiaXuat, NgayNhap) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                            
    $stmt->bind_param("ssssddds", $MaSP, $TenSP, $LoaiSP, $MauSac, $SoLuongTon, $GiaNhap, $GiaXuat, $NgayNhap);

    if ($stmt->execute()) {
        echo "Thêm sản phẩm thành công!";
    } else {
        echo "Lỗi SQL: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
 else {
    echo "Yêu cầu không hợp lệ!";
}
?>
