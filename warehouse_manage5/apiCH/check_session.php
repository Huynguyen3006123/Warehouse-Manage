<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();

// Ghi log để debug
error_log("Session data: " . print_r($_SESSION, true));

if (isset($_SESSION['UserID']) && isset($_SESSION['Role'])) {
    // Nếu là Cửa Hàng, lấy MaCH từ bảng cuahang
    if ($_SESSION['Role'] === 'Cửa Hàng') {
        require '../api/db.php';
        if (!$conn) {
            error_log("Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error);
            echo json_encode(['success' => false, 'message' => 'Lỗi kết nối cơ sở dữ liệu']);
            exit();
        }

        $userID = $_SESSION['UserID'];
        error_log("UserID: " . $userID);

        $stmt = $conn->prepare("SELECT MaCH FROM cuahang WHERE UserID = ?");
        if (!$stmt) {
            error_log("Lỗi chuẩn bị truy vấn: " . $conn->error);
            echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn cơ sở dữ liệu']);
            exit();
        }

        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $shop = $result->fetch_assoc();
            $_SESSION['MaCH'] = $shop['MaCH'];
            error_log("MaCH: " . $shop['MaCH']);
        } else {
            error_log("Không tìm thấy cửa hàng cho UserID: " . $userID);
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy cửa hàng']);
            exit();
        }
        $stmt->close();
        $conn->close();
    }

    $response = [
        'success' => true,
        'role' => $_SESSION['Role'],
        'maCH' => isset($_SESSION['MaCH']) ? $_SESSION['MaCH'] : null
    ];
} else {
    $response = [
        'success' => false,
        'message' => 'Chưa đăng nhập'
    ];
}

echo json_encode($response);
?>