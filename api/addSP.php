<?php
include 'db.php';

try {
    $conn->autocommit(FALSE); // Tắt tự động commit

    $conn->query("INSERT INTO khachhang (MaKH, TenKH, DiaChi, SoDienThoai, Email) 
              VALUES ('KH1', 'Nguyen Van A', '123 Le Loi', '0987654321', 'a@gmail.com')");

    // Thêm dữ liệu vào bảng xuat
    $conn->query("INSERT INTO xuat (MaXuat, MaSP, SoLuong, GiaXuat, NgayXuat, MaKH) 
                VALUES ('X1', '1', 5, 50000, '2025-02-19', 'KH1')");

    // Thêm dữ liệu vào bảng hoadon
    $conn->query("INSERT INTO hoadon (MaDon, MaKH, NgayDat, MaSP, SoLuong, DonGia, ThanhTien, TrangThai, GhiChu) 
                VALUES ('HD1', 'KH1', '2025-02-19', '1', 5, 50000, 250000, 'Đã giao', 'Giao hàng thành công')");

    // Trừ số lượng sản phẩm trong bảng sanpham
    $conn->query("UPDATE sanpham 
                SET SoLuong = SoLuong - 5 
                WHERE MaSP = '1'");
    
    
    $conn->commit(); // Xác nhận giao dịch
    echo "Dữ liệu mẫu đã được thêm thành công!";
} catch (Exception $e) {
    $conn->rollback(); // Quay lại nếu có lỗi
    echo "Lỗi: " . $e->getMessage();
}
?>
