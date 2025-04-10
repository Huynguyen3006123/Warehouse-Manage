<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

$sql = "SELECT sp.MaSP, sp.TenSP, sp.LoaiSP, sp.KichCo, sp.MauSac, sp.GiaNhap, sp.GiaXuat, 
               COALESCE(SUM(cx.SoLuongXuat), 0) AS TongSoLuongXuat, 
               COALESCE(SUM(cn.SoLuongNhap), 0) AS TongSoLuongNhap, 
               sp.SoLuongTon, sp.TrangThai
        FROM sanpham AS sp
        LEFT JOIN chitietnhap AS cn ON cn.MaSP = sp.MaSP
        LEFT JOIN chitietxuat AS cx ON cx.MaSP = sp.MaSP
        GROUP BY sp.MaSP, sp.TenSP, sp.LoaiSP, sp.KichCo, sp.MauSac, sp.GiaNhap, sp.GiaXuat, sp.SoLuongTon, sp.TrangThai";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . $conn->error]);
    exit();
}

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi thực thi truy vấn: ' . $stmt->error]);
    exit();
}

// Gán các biến để nhận kết quả từ truy vấn
$stmt->bind_result($maSP, $tenSP, $loaiSP, $kichCo, $mauSac, $giaNhap, $giaXuat, $tongSoLuongXuat, $tongSoLuongNhap, $soLuongTon, $trangThai);

// Lấy dữ liệu và lưu vào mảng
$data = [];
while ($stmt->fetch()) {
    $data[] = [
        'MaSP' => $maSP,
        'TenSP' => $tenSP,
        'LoaiSP' => $loaiSP,
        'KichCo' => $kichCo,
        'MauSac' => $mauSac,
        'GiaNhap' => $giaNhap,
        'GiaXuat' => $giaXuat,
        'TongSoLuongXuat' => $tongSoLuongXuat,
        'TongSoLuongNhap' => $tongSoLuongNhap,
        'SoLuongTon' => $soLuongTon,
        'TrangThai' => $trangThai
    ];
}

// Trả về JSON
echo json_encode(['success' => true, 'data' => $data]);

$stmt->close();
$conn->close();
?>