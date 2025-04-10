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
    // Đếm tổng số lượng sản phẩm nhập và xuất theo ngày trong 30 ngày, chỉ lấy TrangThai = 'confirmed'
    $sql_nhap = "SELECT DATE(n.NgayNhap) as date, SUM(cn.SoLuongNhap) as total 
                 FROM nhap n
                 JOIN chitietnhap cn ON n.MaPN = cn.MaPN
                 WHERE n.NgayNhap >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
                 AND n.TrangThai = 'confirmed'
                 GROUP BY DATE(n.NgayNhap) 
                 ORDER BY n.NgayNhap ASC";
    $sql_xuat = "SELECT DATE(x.NgayXuat) as date, SUM(cx.SoLuongXuat) as total 
                 FROM xuat x
                 JOIN chitietxuat cx ON x.MaPX = cx.MaPX
                 WHERE x.NgayXuat >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
                 AND x.TrangThai = 'confirmed'
                 GROUP BY DATE(x.NgayXuat) 
                 ORDER BY x.NgayXuat ASC";
    $date_format = 'd/m';
} else {
    // Đếm tổng số lượng sản phẩm nhập và xuất theo tháng trong 12 tháng, chỉ lấy TrangThai = 'confirmed'
    $sql_nhap = "SELECT DATE_FORMAT(n.NgayNhap, '%Y-%m') as date, SUM(cn.SoLuongNhap) as total 
                 FROM nhap n
                 JOIN chitietnhap cn ON n.MaPN = cn.MaPN
                 WHERE n.NgayNhap >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) 
                 AND n.TrangThai = 'confirmed'
                 GROUP BY DATE_FORMAT(n.NgayNhap, '%Y-%m') 
                 ORDER BY n.NgayNhap ASC";
    $sql_xuat = "SELECT DATE_FORMAT(x.NgayXuat, '%Y-%m') as date, SUM(cx.SoLuongXuat) as total 
                 FROM xuat x
                 JOIN chitietxuat cx ON x.MaPX = cx.MaPX
                 WHERE x.NgayXuat >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) 
                 AND x.TrangThai = 'confirmed'
                 GROUP BY DATE_FORMAT(x.NgayXuat, '%Y-%m') 
                 ORDER BY x.NgayXuat ASC";
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