<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

if (isset($_GET['MaPN'])) {
    $maPN = $_GET['MaPN'];

    // Lấy danh sách MaSP từ bảng chitietnhap
    $sql_chitiet = "SELECT MaSP, SoLuongNhap FROM chitietnhap WHERE MaPN = ?";
    $stmt_chitiet = $conn->prepare($sql_chitiet);
    if ($stmt_chitiet === false) {
        echo json_encode(["error" => "Lỗi chuẩn bị câu truy vấn chitietnhap: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt_chitiet->bind_param("s", $maPN);
    $stmt_chitiet->execute();
    $result_chitiet = $stmt_chitiet->get_result();

    $maSP_list = [];
    $soLuongNhap_map = [];
    while ($row = $result_chitiet->fetch_assoc()) {
        $maSP_list[] = $row['MaSP'];
        $soLuongNhap_map[$row['MaSP']] = $row['SoLuongNhap'];
    }
    $stmt_chitiet->close();

    $data = [];
    if (!empty($maSP_list)) {
        // Lấy thông tin sản phẩm từ bảng sanpham
        $placeholders = implode(',', array_fill(0, count($maSP_list), '?'));
        $sql_sanpham = "SELECT MaSP, TenSP, LoaiSP, KichCo, MauSac, GiaNhap FROM sanpham WHERE MaSP IN ($placeholders)";
        $stmt_sanpham = $conn->prepare($sql_sanpham);
        if ($stmt_sanpham === false) {
            echo json_encode(["error" => "Lỗi chuẩn bị câu truy vấn sanpham: " . $conn->error]);
            $conn->close();
            exit;
        }
        $stmt_sanpham->bind_param(str_repeat("i", count($maSP_list)), ...$maSP_list);
        $stmt_sanpham->execute();
        $result_sanpham = $stmt_sanpham->get_result();

        while ($row = $result_sanpham->fetch_assoc()) {
            $row['SoLuongNhap'] = $soLuongNhap_map[$row['MaSP']] ?? 0;
            $data[] = $row;
        }
        $stmt_sanpham->close();
    }

    echo json_encode($data, JSON_NUMERIC_CHECK);
} else {
    echo json_encode([]);
}

$conn->close();
?>