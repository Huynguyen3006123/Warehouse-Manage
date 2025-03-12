<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSP = $_POST['MaSP'] ?? '';
    $TenSP = $_POST['TenSP'] ?? '';
    $LoaiSP = $_POST['LoaiSP'] ?? '';
    $MauSac = $_POST['MauSac'] ?? '';
    $SoLuongTon = 0;
    $Gia = $_POST['Gia'] ?? 0;

    if (empty($MaSP) || empty($TenSP)) {
        echo "Thiếu thông tin sản phẩm!";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO sanpham (MaSP, TenSP, LoaiSP, MauSac, SoLuongTon, Gia) 
                            VALUES (?, ?, ?, ?, ?, ? )");
    $stmt->bind_param("ssssid", $MaSP, $TenSP, $LoaiSP, $MauSac, $SoLuongTon, $Gia);

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
