<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSP = $_POST['MaSP'];
    $TenSP = $_POST['TenSP'];
    $MaDanhMuc = $_POST['MaDanhMuc'];
    $DVT = $_POST['DVT'];
    $SoLuong = $_POST['SoLuong'];
    $GiaNhap = $_POST['GiaNhap'];
    $GiaBanLe = $_POST['GiaBanLe'];
    $GiaBanSi = $_POST['GiaBanSi'];
    $MoTa = $_POST['MoTa'];
    $MaNCC = $_POST['MaNCC'];

    $sql = "UPDATE sanpham SET TenSP='$TenSP', MaDanhMuc='$MaDanhMuc', DVT='$DVT', SoLuong=$SoLuong, 
            GiaNhap=$GiaNhap, GiaBanLe=$GiaBanLe, GiaBanSi=$GiaBanSi, MoTa='$MoTa', MaNCC='$MaNCC'
            WHERE MaSP='$MaSP'";

    if ($conn->query($sql) === TRUE) {
        echo "Cập nhật sản phẩm thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
