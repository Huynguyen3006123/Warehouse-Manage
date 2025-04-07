<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

session_start();
if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit();
}

$period = $_GET['period'] ?? 'month';
$data = ['labels' => [], 'nhap' => [], 'xuat' => []];

if ($period === 'month') {
    // Đếm số phiếu nhập và xuất theo ngày trong 30 ngày, chỉ lấy TrangThai = 'confirmed'
    $sql_nhap = "SELECT DATE(NgayNhap) as date, COUNT(MaPN) as total 
                 FROM nhap 
                 WHERE NgayNhap >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
                 AND TrangThai = 'confirmed'
                 GROUP BY DATE(NgayNhap) 
                 ORDER BY NgayNhap ASC";
    $sql_xuat = "SELECT DATE(NgayXuat) as date, COUNT(MaPX) as total 
                 FROM xuat 
                 WHERE NgayXuat >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
                 AND TrangThai = 'confirmed'
                 GROUP BY DATE(NgayXuat) 
                 ORDER BY NgayXuat ASC";
    $date_format = 'd/m';
} else {
    // Đếm số phiếu nhập và xuất theo tháng trong 12 tháng, chỉ lấy TrangThai = 'confirmed'
    $sql_nhap = "SELECT DATE_FORMAT(NgayNhap, '%Y-%m') as date, COUNT(MaPN) as total 
                 FROM nhap 
                 WHERE NgayNhap >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) 
                 AND TrangThai = 'confirmed'
                 GROUP BY DATE_FORMAT(NgayNhap, '%Y-%m') 
                 ORDER BY NgayNhap ASC";
    $sql_xuat = "SELECT DATE_FORMAT(NgayXuat, '%Y-%m') as date, COUNT(MaPX) as total 
                 FROM xuat 
                 WHERE NgayXuat >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) 
                 AND TrangThai = 'confirmed'
                 GROUP BY DATE_FORMAT(NgayXuat, '%Y-%m') 
                 ORDER BY NgayXuat ASC";
    $date_format = 'm/Y';
}

$result_nhap = $conn->query($sql_nhap);
$nhap_data = [];
while ($row = $result_nhap->fetch_assoc()) {
    $nhap_data[$row['date']] = (int)$row['total'];
}

$result_xuat = $conn->query($sql_xuat);
$xuat_data = [];
while ($row = $result_xuat->fetch_assoc()) {
    $xuat_data[$row['date']] = (int)$row['total'];
}

if ($period === 'month') {
    for ($i = 29; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $label = date($date_format, strtotime($date));
        $data['labels'][] = $label;
        $data['nhap'][] = $nhap_data[$date] ?? 0;
        $data['xuat'][] = $xuat_data[$date] ?? 0;
    }
} else {
    for ($i = 11; $i >= 0; $i--) {
        $date = date('Y-m', strtotime("-$i months"));
        $label = date($date_format, strtotime($date));
        $data['labels'][] = $label;
        $data['nhap'][] = $nhap_data[$date] ?? 0;
        $data['xuat'][] = $xuat_data[$date] ?? 0;
    }
}

echo json_encode(['success' => true, 'data' => $data]);
$conn->close();
?>