<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>xuat Table</title>
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
    <h2>xuat Table</h2>
    <table>
        <thead>
            <tr>	
                <th>MaXuat</th>
                <th>MaSP</th>
                <th>SoLuong</th>
                <th>GiaXuat</th>
                <th>NgayXuat</th>
                <th>MaKH</th>
            </tr>
        </thead>
        <tbody id="xuatTableBody">
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $.getJSON("api/xuat.php", function (data) {
                let rows = "";
                data.forEach(user => {
                    rows += `<tr>
                        <td>${xuat.MaXuat}</td>
                        <td>${xuat.MaSP}</td>
                        <td>${xuat.SoLuong}</td>
                        <td>${xuat.GiaXuat}</td>
                        <td>${xuat.NgayXuat}</td>
                        <td>${xuat.MaKH}</td>
                    </tr>`;
                });
                $("#xuatTableBody").html(rows);
            });
        });
    </script>
</body>
</html>
<?php
include 'db.php';

$sql = "SELECT * FROM xuat";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>
