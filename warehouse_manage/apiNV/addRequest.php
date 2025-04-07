<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php'; // Đường dẫn đúng cho thư mục apiNV/

session_start();
if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit();
}

// Kiểm tra tham số đầu vào
if (!isset($_POST['MaPN'], $_POST['MaNCC'], $_POST['NgayNhap'], $_POST['MaHoaDon'], $_POST['MaSP'], $_POST['SoLuongNhap'], $_POST['GiaNhap'])) {
    echo json_encode(['success' => false, 'message' => 'Thiếu tham số']);
    exit();
}

$MaPN = $_POST['MaPN'];
$MaNCC = $_POST['MaNCC'];
$NgayNhap = $_POST['NgayNhap'];
$MaNV = $_SESSION['MaNV'] ?? ''; // Lấy từ session thay vì POST
$MaHoaDon = $_POST['MaHoaDon'];
$MaSPs = $_POST['MaSP'];
$SoLuongNhaps = $_POST['SoLuongNhap'];
$GiaNhaps = $_POST['GiaNhap'];

// Kiểm tra session MaNV
if (empty($MaNV)) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy mã nhân viên trong session']);
    exit();
}

// Kiểm tra mảng MaSP
if (empty($MaSPs) || !is_array($MaSPs)) {
    echo json_encode(['success' => false, 'message' => 'Danh sách sản phẩm rỗng']);
    exit();
}

// Kiểm tra độ dài mảng
if (count($MaSPs) !== count($SoLuongNhaps) || count($MaSPs) !== count($GiaNhaps)) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu sản phẩm không hợp lệ']);
    exit();
}

// Bật chế độ báo lỗi MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn->begin_transaction();

    // Thêm vào bảng nhap
    $sql = "INSERT INTO nhap (MaPN, MaNCC, NgayNhap, MaNV, TrangThai, MaHoaDon) 
            VALUES (?, ?, ?, ?, 'pending', ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception('Lỗi khi chuẩn bị truy vấn nhap: ' . $conn->error);
    }
    $stmt->bind_param("sssss", $MaPN, $MaNCC, $NgayNhap, $MaNV, $MaHoaDon);
    if (!$stmt->execute()) {
        throw new Exception('Lỗi khi thêm vào nhap: ' . $stmt->error);
    }

    // Thêm chi tiết vào bảng chitietnhap
    $sqlDetail = "INSERT INTO chitietnhap (MaPN, MaSP, SoLuongNhap, GiaNhap) 
                  VALUES (?, ?, ?, ?)";
    $stmtDetail = $conn->prepare($sqlDetail);
    if ($stmtDetail === false) {
        throw new Exception('Lỗi khi chuẩn bị truy vấn chitietnhap: ' . $conn->error);
    }

    for ($i = 0; $i < count($MaSPs); $i++) {
        $MaSP = $MaSPs[$i];
        $SoLuongNhap = $SoLuongNhaps[$i];
        $GiaNhap = $GiaNhaps[$i];
        $stmtDetail->bind_param("sssd", $MaPN, $MaSP, $SoLuongNhap, $GiaNhap);
        if (!$stmtDetail->execute()) {
            throw new Exception('Lỗi khi thêm vào chitietnhap: ' . $stmtDetail->error);
        }
    }

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Yêu cầu nhập hàng đã được tạo']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Lỗi khi tạo yêu cầu: ' . $e->getMessage()]);
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($stmtDetail)) $stmtDetail->close();
    $conn->close();
}
?>