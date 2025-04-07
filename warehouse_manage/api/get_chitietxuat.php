<?php
include 'db.php'; 

if (isset($_GET['MaPX'])) {
    $MaPX = $_GET['MaPX'];

    $sql = "SELECT cx.MaPX, cx.MaSP, sp.TenSP, cx.SoLuongXuat, cx.DonGia, cx.ThanhTien
            FROM ChiTietXuat cx
            JOIN SanPham sp ON cx.MaSP = sp.MaSP
            WHERE cx.MaPX = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $MaPX);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'MaPX' => (int)$row['MaPX'],
            'MaSP' => (int)$row['MaSP'],
            'TenSP' => $row['TenSP'],
            'SoLuongXuat' => (int)$row['SoLuongXuat'],
            'DonGia' => (float)$row['DonGia'], // Giữ kiểu số
            'ThanhTien' => (float)$row['ThanhTien'] // Giữ kiểu số
        ];
    }

    echo json_encode($data);
}
?>
