<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hoadon Table</title>
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
    <h2>hoadon Table</h2>
    <table>
        <thead>
            <tr>
                <th>MaDon</th>
                <th>MaKH</th>
                <th>NgayDat</th>
                <th>MaSP</th>
                <th>SoLuong</th>
                <th>DonGia</th>
                <th>ThanhTien</th>
                <th>TrangThai</th>
                <th>GhiChu</th>
            </tr>
        </thead>
        <tbody id="hoadonTableBody">
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $.getJSON("api/hoadon.php", function (data) {
                let rows = "";
                data.forEach(user => {
                    rows += `<tr>
                        <td>${hoadon.MaDon}</td>
                        <td>${hoadon.MaKH}</td>
                        <td>${hoadon.NgayDat}</td>
                        <td>${hoadon.MaSP}</td>
                        <td>${hoadon.SoLuong}</td>
                        <td>${hoadon.DonGia}</td>
                        <td>${hoadon.ThanhTien}</td>
                        <td>${hoadon.TrangThai}</td>
                        <td>${hoadon.GhiChu}</td>
                    </tr>`;
                });
                $("#hoadonTableBody").html(rows);
            });
        });
    </script>
</body>
</html>
<?php
include 'db.php';

$sql = "SELECT * FROM hoadon";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>
