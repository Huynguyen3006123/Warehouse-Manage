<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sản Phẩm</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/product.css">
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- Sidebar (giống dashboard) -->
    <div class="sidebar">
        <h2>Trang chính</h2>
        <ul>
            <li><a href="dashboard.php">Tổng quan</a></li>
            <li><a href="sanpham.php">Quản lý sản phẩm</a></li>
            <li><a href="nhap.php">Nhập kho</a></li>
            <li><a href="xuat.php">Xuất kho</a></li>
            <li><a href="hoadon.php">Hoá Đơn</a></li>
        </ul>
        <a href="logout.php" class="logout-btn">Đăng xuất</a>
    </div>

    <!-- Vùng hiển thị bảng -->
    <div class="table-container">
        <button id="addProductBtn">Thêm Sản Phẩm</button>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Mã SP</th>
                    <th>Tên SP</th>
                    <th>Loại Sản Phẩm</th>
                    <th>Màu Sắc</th>
                    <th>Số Lượng Tồn</th>
                    <th>Giá</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody id="sanphamTableBody"></tbody>
        </table>
    </div>

    <!-- Modal for adding product -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="addProductForm">
                <input type="text" name="MaSP" placeholder="Mã SP" required>
                <input type="text" name="TenSP" placeholder="Tên SP" required>
                <input type="text" name="LoaiSP" placeholder="Loai Sản Phẩm" required>
                <input type="text" name="MauSac" placeholder="Màu Sắc" required>
                <input type="number" step="0.01" name="Gia" placeholder="Giá" required>
                <button type="submit">Thêm Sản Phẩm</button>
            </form>
        </div>
    </div>

    <!-- Script jQuery -->
    <script>
        $(document).ready(function () {
            $.getJSON("api/sanpham.php", function (data) {
                let rows = "";
                data.forEach(sanpham => {
                    rows += `
                        <tr>
                            <td>${sanpham.MaSP}</td>
                            <td>${sanpham.TenSP}</td>
                            <td>${sanpham.LoaiSP}</td>
                            <td>${sanpham.MauSac}</td>
                            <td>${sanpham.SoLuongTon}</td>
                            <td>${sanpham.Gia}</td>
                            <td>
                                <button class="deleteBtn" data-id="${sanpham.MaSP}">Xóa</button>
                            </td>
                        </tr>
                    `;
                });
                $("#sanphamTableBody").html(rows);
            });

            $("#addProductBtn").click(function() {
                $("#addProductModal").show();
            });

            $(".close").click(function() {
                $("#addProductModal").hide();
            });

            // Add product via AJAX
            $("#addProductForm").submit(function (event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "api/addSP.php",
                    data: $(this).serialize(),
                    success: function (response) {
                        alert(response);
                        location.reload();
                    }
                });
            });
            // $(document).on("click", ".editBtn", function () {
            //     let productId = $(this).data("id");

            //     $.getJSON("api/getSP.php", { MaSP: productId }, function (data) {
            //         $("#edit_MaSP").val(data.MaSP);
            //         $("#edit_TenSP").val(data.TenSP);
            //         $("#edit_MaDanhMuc").val(data.MaDanhMuc);
            //         $("#edit_DVT").val(data.DVT);
            //         $("#edit_SoLuong").val(data.SoLuong);
            //         $("#edit_GiaNhap").val(data.GiaNhap);
            //         $("#edit_GiaBanLe").val(data.GiaBanLe);
            //         $("#edit_GiaBanSi").val(data.GiaBanSi);
            //         $("#edit_MoTa").val(data.MoTa);
            //         $("#edit_MaNCC").val(data.MaNCC);
            //         $("#editProductModal").show();
            //     });
            // });

            // // Đóng modal sửa
            // $(".close").click(function () {
            //     $("#editProductModal").hide();
            // });

            // // Gửi yêu cầu cập nhật
            // $("#editProductForm").submit(function (event) {
            //     event.preventDefault();
            //     $.ajax({
            //         type: "POST",
            //         url: "api/updateSP.php",
            //         data: $(this).serialize(),
            //         success: function (response) {
            //             alert(response);
            //             location.reload();
            //         }
            //     });
            // });

            // Xóa sản phẩm
            $(document).on("click", ".deleteBtn", function () {
                let productId = $(this).data("id");
                if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
                    $.post("api/deleteSP.php", { MaSP: productId }, function (response) {
                        alert(response);
                        location.reload();
                    });
                }
            });
        });

    </script>
<!-- <div id="editProductModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="editProductForm">
            <input type="hidden" name="MaSP" id="edit_MaSP">
            <input type="text" name="TenSP" id="edit_TenSP" placeholder="Tên SP" required>
            <input type="text" name="MaDanhMuc" id="edit_MaDanhMuc" placeholder="Mã Danh Mục" required>
            <input type="text" name="DVT" id="edit_DVT" placeholder="ĐVT" required>
            <input type="number" name="SoLuong" id="edit_SoLuong" placeholder="Số Lượng" required>
            <input type="number" step="0.01" name="GiaNhap" id="edit_GiaNhap" placeholder="Giá Nhập" required>
            <input type="number" step="0.01" name="GiaBanLe" id="edit_GiaBanLe" placeholder="Giá Bán Lẻ" required>
            <input type="number" step="0.01" name="GiaBanSi" id="edit_GiaBanSi" placeholder="Giá Bán Sỉ" required>
            <input type="text" name="MoTa" id="edit_MoTa" placeholder="Mô Tả" required>
            <input type="text" name="MaNCC" id="edit_MaNCC" placeholder="Mã NCC" required>
            <button type="submit">Cập Nhật</button>
        </form>
    </div>
</div> -->

</body>
</html>
