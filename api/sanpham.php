<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sanpham Table</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>SanPham Table</h2>
    <table>
        <thead>
                <th>MaSP</th>
                <th>TenSP</th>
                <th>MaDanhMuc</th>
                <th>DVT</th>
                <th>SoLuong</th>
                <th>GiaNhap</th>
                <th>GiaBanLe</th>
                <th>GiaBanSi</th>
                <th>MoTa</th>
                <th>MaNCC</th>
            </tr>
        </thead>
        <tbody id="sanphamTableBody">
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $.getJSON("api/sanpham.php", function (data) {
                let rows = "";
                data.forEach(user => {
                    rows += `<tr>
                        <td>${sanpham.MaSP}</td>
                        <td>${sanpham.TenSP}</td>
                        <td>${sanpham.MaDanhMuc}</td>
                        <td>${sanpham.DVT}</td>
                        <td>${sanpham.SoLuong}</td>
                        <td>${sanpham.GiaNhap}</td>
                        <td>${sanpham.GiaBanLe}</td>
                        <td>${sanpham.GiaBanSi}</td>
                        <td>${sanpham.MoTa}</td>
                        <td>${sanpham.MaNCC}</td>
                    </tr>`;
                });
                $("#sanphamTableBody").html(rows);
            });
        });
    </script>
</body>
</html>
<?php
include 'db.php';

$sql = "SELECT * FROM sanpham";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>
