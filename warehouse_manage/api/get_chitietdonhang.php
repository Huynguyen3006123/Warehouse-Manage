<?php
include 'db.php'; 

if (isset($_GET['MaDon'])) {
    $MaDon = $_GET['MaDon'];

    $sql = "SELECT cx.MaChiTiet, cx.MaDon, cx.MaSP, cx.SoLuong, cx.DonGia, cx.ThanhTien
            FROM chitietdonhang cx
            WHERE cx.MaDon = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $MaDon);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>
