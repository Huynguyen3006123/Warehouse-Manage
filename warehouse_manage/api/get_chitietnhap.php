<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php'; // Đảm bảo đường dẫn đúng (nếu ở root thì '../db.php')

session_start();

// Kiểm tra quyền truy cập (chỉ Quản lý)
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] !== "Quản lý") {
    echo json_encode(['success' => false, 'message' => 'Không có quyền truy cập']);
    exit();
}

if (isset($_GET['MaPN'])) {
    $maPN = $_GET['MaPN'];

    // Truy vấn JOIN để tối ưu
    $sql = "SELECT sp.MaSP, sp.TenSP, sp.LoaiSP, sp.KichCo, sp.MauSac, sp.GiaNhap, ctn.SoLuongNhap 
            FROM chitietnhap ctn
            JOIN sanpham sp ON ctn.MaSP = sp.MaSP
            WHERE ctn.MaPN = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Lỗi chuẩn bị câu truy vấn: ' . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("s", $maPN);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->close();

    echo json_encode($data, JSON_NUMERIC_CHECK);
} else {
    echo json_encode(['success' => false, 'message' => 'Thiếu tham số MaPN']);
}

$conn->close();
?>