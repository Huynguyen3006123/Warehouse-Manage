<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();

// Kiểm tra session
if (!isset($_SESSION['UserID']) || !isset($_SESSION['Role']) || $_SESSION['Role'] !== 'Cửa Hàng') {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập hoặc không có quyền']);
    exit();
}

// Kiểm tra dữ liệu đầu vào
if (!isset($_POST['maSP']) || !isset($_POST['soLuong']) || !isset($_POST['donGia'])) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm']);
    exit();
}

$maSP = (int)$_POST['maSP'];
$soLuong = (int)$_POST['soLuong'];
$donGia = (float)$_POST['donGia'];

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
    // Kiểm tra số lượng tồn
    $stmt = $conn->prepare("SELECT SoLuongTon FROM sanpham WHERE MaSP = ?");
    $stmt->bind_param("i", $maSP);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Sản phẩm không tồn tại");
    }
    $row = $result->fetch_assoc();
    $soLuongTon = $row['SoLuongTon'];
    $stmt->close();

    if ($soLuong > $soLuongTon) {
        throw new Exception("Số lượng tồn không đủ (còn lại: $soLuongTon)");
    }

    // Trừ số lượng tồn
    $stmt = $conn->prepare("UPDATE sanpham SET SoLuongTon = SoLuongTon - ? WHERE MaSP = ?");
    $stmt->bind_param("ii", $soLuong, $maSP);
    if (!$stmt->execute()) {
        throw new Exception("Lỗi khi cập nhật số lượng tồn: " . $stmt->error);
    }
    $stmt->close();

    // Thêm vào giỏ hàng (lưu trong session)
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$maSP])) {
        $_SESSION['cart'][$maSP]['soLuong'] += $soLuong;
    } else {
        $_SESSION['cart'][$maSP] = [
            'soLuong' => $soLuong,
            'donGia' => $donGia
        ];
    }

    // Commit transaction
    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng']);
} catch (Exception $e) {
    // Rollback transaction nếu có lỗi
    $conn->rollback();
    error_log("Lỗi khi thêm vào giỏ hàng: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Lỗi khi thêm vào giỏ hàng: ' . $e->getMessage()]);
}

$conn->close();
?>