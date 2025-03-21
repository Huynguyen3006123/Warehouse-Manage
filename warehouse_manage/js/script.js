$(document).ready(function () {
    // Hiển thị modal khi nhấn nút Thêm Sản Phẩm
    $("#addProductBtn").click(function () {
        console.log("✅ Nút Thêm Sản Phẩm đã được click!");
        $("#addProductModal").fadeIn();
    });

    // Đóng modal khi nhấn vào nút đóng
    $(".close").click(function () {
        $("#addProductModal").fadeOut();
    });

    // Đóng modal khi nhấn ra ngoài modal
    $(window).click(function (event) {
        if ($(event.target).is("#addProductModal")) {
            $("#addProductModal").fadeOut();
        }
    });

    // Xử lý gửi form bằng AJAX
    $("#addProductForm").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "addSP.php",
            data: $(this).serialize(),
            success: function (response) {
                alert(response);
                $("#addProductModal").fadeOut();
                location.reload(); // Tải lại trang để cập nhật sản phẩm mới
            },
            error: function () {
                alert("Lỗi khi thêm sản phẩm!");
            }
        });
    });
});
