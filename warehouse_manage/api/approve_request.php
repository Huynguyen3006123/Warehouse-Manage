<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

if (isset($_POST['MaPN'])) {
    $maPN = $_POST['MaPN'];

    // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
    $conn->begin_transaction();

    try {
        // Lấy chi tiết phiếu nhập từ bảng chitietnhap
        $sql_detail = "SELECT MaSP, SoLuongNhap FROM chitietnhap WHERE MaPN = ?";
        $stmt_detail = $conn->prepare($sql_detail);
        $stmt_detail->bind_param("s", $maPN);
        $stmt_detail->execute();
        $result = $stmt_detail->get_result();

        // Cập nhật số lượng tồn cho từng sản phẩm
        while ($row = $result->fetch_assoc()) {
            $maSP = $row['MaSP'];
            $soLuongNhap = $row['SoLuongNhap'];

            // Cập nhật số lượng tồn trong bảng sanpham
            $sql_update = "UPDATE sanpham SET SoLuongTon = SoLuongTon + ? WHERE MaSP = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("is", $soLuongNhap, $maSP);

            if (!$stmt_update->execute()) {
                throw new Exception("Lỗi khi cập nhật số lượng tồn cho sản phẩm $maSP");
            }
            $stmt_update->close();
        }
        $stmt_detail->close();

        // Cập nhật trạng thái phiếu nhập thành 'confirmed'
        $sql_status = "UPDATE nhap SET TrangThai = 'confirmed' WHERE MaPN = ?";
        $stmt_status = $conn->prepare($sql_status);
        $stmt_status->bind_param("s", $maPN);

        if (!$stmt_status->execute()) {
            throw new Exception("Lỗi khi cập nhật trạng thái phiếu nhập");
        }
        $stmt_status->close();

        // Commit transaction nếu tất cả thành công
        $conn->commit();
        echo json_encode(["message" => "Yêu cầu đã được duyệt và số lượng tồn đã được cập nhật"]);

    } catch (Exception $e) {
        // Rollback transaction nếu có lỗi
        $conn->rollback();
        echo json_encode(["error" => $e->getMessage()]);
    }

} else {
    echo json_encode(["error" => "Không tìm thấy mã phiếu nhập"]);
}

$conn->close();
?>