<?php
include 'db.php'; 

if (isset($_GET['MaPN'])) {
    $MaPN = $_GET['MaPN'];

    $sql = "SELECT cn.MaPN, cn.MaSP, sp.TenSP, cn.SoLuongNhap, cn.GiaNhap
            FROM chitietnhap cn
            JOIN sanpham sp ON cn.MaSP = sp.MaSP
            WHERE cn.MaPN = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $MaPN);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>
