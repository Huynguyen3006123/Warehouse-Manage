<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nhap Table</title>
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
    <h2>nhap Table</h2>
    <table>
        <thead>
            <tr>
                <th>MaNhap</th>
                <th>MaSP</th>
                <th>SoLuong</th>
                <th>GiaNhap</th>
                <th>NgayNhap</th>
                <th>MaNCC</th>
            </tr>
        </thead>
        <tbody id="nhapTableBody">
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $.getJSON("api/nhap.php", function (data) {
                let rows = "";
                data.forEach(user => {
                    rows += `<tr>
                        <td>${nhap.MaNhap}</td>
                        <td>${nhap.MaSP}</td>
                        <td>${nhap.SoLuong}</td>
                        <td>${nhap.GiaNhap}</td>
                        <td>${nhap.NgayNhap}</td>
                        <td>${nhap.MaNCC}</td>
                    </tr>`;
                });
                $("#nhapTableBody").html(rows);
            });
        });
    </script>
</body>
</html>
<?php
include 'db.php';

$sql = "SELECT * FROM nhap";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>
