<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php'; // Đường dẫn đúng cho thư mục apiNV/

session_start();
if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit();
}

// Kiểm tra tham số đầu vào
if (!isset($_POST['MaPN'], $_POST['MaNCC'], $_POST['NgayNhap'], $_POST['MaSP'], $_POST['SoLuongNhap'])) {
    echo json_encode(['success' => false, 'message' => 'Thiếu tham số']);
    exit();
}

$MaPN = $_POST['MaPN'];
$MaNCC = $_POST['MaNCC'];
$NgayNhap = $_POST['NgayNhap'];
$MaNV = $_SESSION['MaNV'] ?? ''; // Lấy từ session
$MaSPs = $_POST['MaSP']; // Mảng MaSP
$SoLuongNhaps = $_POST['SoLuongNhap']; // Mảng SoLuongNhap

// Kiểm tra session MaNV
if (empty($MaNV)) {
    // Nếu MaNV không có trong session, thử lấy từ UserID
    $userID = $_SESSION['UserID'];
    $sql = "SELECT MaNV FROM nhanvien WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $MaNV = $row['MaNV'];
    } else {
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy mã nhân viên cho tài khoản này']);
        exit();
    }
    $stmt->close();
}

// Kiểm tra mảng MaSP và SoLuongNhap
if (!is_array($MaSPs) || empty($MaSPs) || count($MaSPs) !== count($SoLuongNhaps)) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu sản phẩm không hợp lệ']);
    exit();
}

// Kiểm tra từng phần tử trong mảng
foreach ($MaSPs as $index => $MaSP) {
    if (empty($MaSP) || !isset($SoLuongNhaps[$index]) || $SoLuongNhaps[$index] <= 0) {
        echo json_encode(['success' => false, 'message' => "Sản phẩm hoặc số lượng không hợp lệ tại mục " . ($index + 1)]);
        exit();
    }
}

// Bật chế độ báo lỗi MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn->begin_transaction();

    // Thêm vào bảng nhap
    $sql = "INSERT INTO nhap (MaPN, MaNCC, NgayNhap, MaNV, TrangThai) 
            VALUES (?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception('Lỗi khi chuẩn bị truy vấn nhap: ' . $conn->error);
    }
    // Giả định MaPN, MaNCC là string, điều chỉnh nếu cần
    $stmt->bind_param("ssss", $MaPN, $MaNCC, $NgayNhap, $MaNV);
    if (!$stmt->execute()) {
        throw new Exception('Lỗi khi thêm vào nhap: ' . $stmt->error);
    }
    $stmt->close();

    // Thêm chi tiết vào bảng chitietnhap
    $sqlDetail = "INSERT INTO chitietnhap (MaPN, MaSP, SoLuongNhap) 
                  VALUES (?, ?, ?)";
    $stmtDetail = $conn->prepare($sqlDetail);
    if ($stmtDetail === false) {
        throw new Exception('Lỗi khi chuẩn bị truy vấn chitietnhap: ' . $conn->error);
    }

    for ($i = 0; $i < count($MaSPs); $i++) {
        $MaSP = $MaSPs[$i];
        $SoLuongNhap = (int)$SoLuongNhaps[$i]; // Ép kiểu về int
        $stmtDetail->bind_param("ssi", $MaPN, $MaSP, $SoLuongNhap); // SoLuongNhap là int
        if (!$stmtDetail->execute()) {
            throw new Exception('Lỗi khi thêm vào chitietnhap cho MaSP ' . $MaSP . ': ' . $stmtDetail->error);
        }
    }
    $stmtDetail->close();

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Yêu cầu nhập hàng đã được tạo']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Lỗi khi tạo yêu cầu: ' . $e->getMessage()]);
} finally {
    $conn->close();
}
?>