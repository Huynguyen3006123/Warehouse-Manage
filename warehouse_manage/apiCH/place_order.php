<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();

// Kiểm tra session
if (!isset($_SESSION['UserID']) || !isset($_SESSION['Role']) || $_SESSION['Role'] !== 'Cửa Hàng' || !isset($_SESSION['MaCH'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập hoặc không có quyền']);
    exit();
}

// Kiểm tra giỏ hàng
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Giỏ hàng trống']);
    exit();
}

// Kết nối cơ sở dữ liệu
require 'db.php';
if (!$conn) {
    error_log("Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error);
    echo json_encode(['success' => false, 'message' => 'Lỗi kết nối cơ sở dữ liệu']);
    exit();
}

// Bắt đầu transaction
$conn->begin_transaction();

try {
    // Kiểm tra MaCH có tồn tại trong bảng cuahang không
    $maCH = $_SESSION['MaCH'];
    $stmt = $conn->prepare("SELECT MaCH FROM cuahang WHERE MaCH = ?");
    if (!$stmt) {
        throw new Exception("Lỗi chuẩn bị truy vấn (kiểm tra MaCH): " . $conn->error);
    }
    $stmt->bind_param("s", $maCH);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Mã cửa hàng không tồn tại trong bảng cuahang");
    }
    $stmt->close();

    // Thêm vào bảng xuat
    $ngayXuat = date('Y-m-d');
    $stmt = $conn->prepare("INSERT INTO xuat (MaCH, NgayXuat, TrangThai) VALUES (?, ?, 'pending')");
    if (!$stmt) {
        throw new Exception("Lỗi chuẩn bị truy vấn (xuat): " . $conn->error);
    }
    $stmt->bind_param("ss", $maCH, $ngayXuat);
    if (!$stmt->execute()) {
        throw new Exception("Lỗi khi thêm phiếu xuất: " . $stmt->error);
    }
    $maPX = $conn->insert_id;
    $stmt->close();

    // Thêm vào bảng chitietxuat
    $stmt = $conn->prepare("INSERT INTO chitietxuat (MaPX, MaSP, SoLuongXuat, DonGia, ThanhTien) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Lỗi chuẩn bị truy vấn (chitietxuat): " . $conn->error);
    }
    
    foreach ($_SESSION['cart'] as $maSP => $item) {
        $soLuong = (int)$item['soLuong'];
        $donGia = (float)$item['donGia'];
        $thanhTien = $soLuong * $donGia;
        $maSP = (int)$maSP;

        $stmt->bind_param("iiidd", $maPX, $maSP, $soLuong, $donGia, $thanhTien);
        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi thêm chi tiết xuất: " . $stmt->error);
        }
    }
    $stmt->close();

    // Commit transaction
    $conn->commit();

    // Xóa giỏ hàng
    unset($_SESSION['cart']);

    echo json_encode(['success' => true, 'message' => 'Đặt hàng thành công', 'maPX' => $maPX], JSON_NUMERIC_CHECK);
} catch (Exception $e) {
    // Rollback transaction nếu có lỗi
    $conn->rollback();
    error_log("Lỗi khi đặt hàng: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Lỗi khi đặt hàng: ' . $e->getMessage()]);
}

$conn->close();
?>