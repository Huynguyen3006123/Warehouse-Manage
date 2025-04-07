<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();

// Kiểm tra session
if (!isset($_SESSION['UserID']) || !isset($_SESSION['Role']) || $_SESSION['Role'] !== 'Cửa Hàng') {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập hoặc không có quyền']);
    exit();
}

// Kiểm tra dữ liệu đầu vào
if (!isset($_POST['maSP'])) {
    echo json_encode(['success' => false, 'message' => 'Thiếu mã sản phẩm']);
    exit();
}

$maSP = (int)$_POST['maSP'];

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
    // Kiểm tra sản phẩm có trong giỏ hàng không
    if (!isset($_SESSION['cart']) || !isset($_SESSION['cart'][$maSP])) {
        throw new Exception("Sản phẩm không có trong giỏ hàng");
    }

    $soLuong = $_SESSION['cart'][$maSP]['soLuong'];

    // Cộng lại số lượng tồn
    $stmt = $conn->prepare("UPDATE sanpham SET SoLuongTon = SoLuongTon + ? WHERE MaSP = ?");
    $stmt->bind_param("ii", $soLuong, $maSP);
    if (!$stmt->execute()) {
        throw new Exception("Lỗi khi cập nhật số lượng tồn: " . $stmt->error);
    }
    $stmt->close();

    // Xóa sản phẩm khỏi giỏ hàng
    unset($_SESSION['cart'][$maSP]);

    // Nếu giỏ hàng rỗng, xóa session cart
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }

    // Commit transaction
    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'Đã bỏ sản phẩm khỏi giỏ hàng']);
} catch (Exception $e) {
    // Rollback transaction nếu có lỗi
    $conn->rollback();
    error_log("Lỗi khi bỏ sản phẩm khỏi giỏ hàng: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Lỗi khi bỏ sản phẩm khỏi giỏ hàng: ' . $e->getMessage()]);
}

$conn->close();
?>