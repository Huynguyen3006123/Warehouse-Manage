<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();

if (isset($_SESSION['UserID']) && isset($_SESSION['Role'])) {
    $response = [
        'success' => true,
        'role' => $_SESSION['Role'],
        'maNV' => isset($_SESSION['MaNV']) ? $_SESSION['MaNV'] : null
    ];
} else {
    $response = [
        'success' => false,
        'message' => 'Chưa đăng nhập'
    ];
}

echo json_encode($response);
?>