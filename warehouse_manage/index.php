<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Table</title>
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
    <h2>User Table</h2>
    <table>
        <thead>
            <tr>
                <th>UserID</th>
                <th>UserName</th>
                <th>Password</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody id="userTableBody">
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $.getJSON("api/donhang.php", function (data) {
                let rows = "";
                data.forEach(user => {
                    rows += `<tr>
                        <td>${user.UserID}</td>
                        <td>${user.UserName}</td>
                        <td>${user.Password}</td>
                        <td>${user.Role}</td>
                    </tr>`;
                });
                $("#userTableBody").html(rows);
            });
        });
    </script>
</body>
</html>