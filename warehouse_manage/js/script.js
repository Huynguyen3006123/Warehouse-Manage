
function loadSanPham() {
    $.ajax({
        url: "sanpham.php",
        method: "GET",
        dataType: "JSON",
        success: function(product) {
            console.log(product);
            let rows = "";
            product.forEach(sp => {
                rows += `
                    <tr>
                        <td>${sp.MaSP}</td>
                        <td>${sp.TenSP}</td>
                        <td>${sp.LoaiSP}</td>
                        <td>${sp.MauSac}</td>
                        <td>${sp.SoLuongTon}</td>
                        <td>${sp.Gia}</td>
                    </tr>
                `;
            });
            $("#sanphamTableBody").html(rows);
        },
        error: function(xhr, status, error) {
            console.error("Error loading products:", error);
        }
    });
}

function setupProductHandlers() {
    $("#addProductBtn").click(function() {
        $("#addProductModal").show();
    });

    $(".close").click(function() {
        $("#addProductModal").hide();
    });

    $("#addProductForm").submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "api/addSP.php",
            data: $(this).serialize(),
            success: function(response) {
                alert(response);
                $("#addProductModal").hide();
                loadSanPham();
            },
            error: function() {
                alert("Lỗi khi thêm sản phẩm!");
            }
        });
    });
}
;