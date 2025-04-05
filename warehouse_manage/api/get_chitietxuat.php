<?php
include 'db.php'; 

if (isset($_GET['MaPX'])) {
    $MaPX = $_GET['MaPX'];

    $sql = "SELECT cx.MaPX, cx.MaSP, sp.TenSP, cx.SoLuongXuat, cx.GiaXuat
            FROM ChiTietXuat cx
            JOIN SanPham sp ON cx.MaSP = sp.MaSP
            WHERE cx.MaPX = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $MaPX);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>
