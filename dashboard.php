<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý kho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    


</head>
<body>
    <!-- Header -->
    <header class="d-flex justify-content-between align-items-center p-3 bg-dark text-white">
        <h3 class="m-0">Quản lý kho</h3>
        <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
    </header>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#">Tổng quan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Quản lý sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Nhập kho</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Xuất kho</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Đơn hàng</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header">Bảng tổng quan</div>
                    <div class="card-body">Nội dung...</div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header">Biểu đồ nhập xuất kho</div>
                    <canvas id="myLineChart" width="400" height="200"></canvas>
                    
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header">Bảng đơn hàng mới nhất</div>
                    <div class="card-body">Nội dung...</div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header">Sản phẩm gần hết hàng</div>
                    <div class="card-body">Nội dung...</div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const ctx = document.getElementById('myLineChart').getContext('2d');

    const myLineChart = new Chart(ctx, {
        type: 'line', // Loại biểu đồ đường
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
            datasets: [{
                label: 'Doanh thu (triệu VND)',
                data: [12, 19, 10, 15, 22, 30],
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                tension: 0.3, // Độ cong của đường
                pointRadius: 5, // Kích thước điểm
                pointBackgroundColor: 'rgba(75, 192, 192, 1)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</body>
</html>