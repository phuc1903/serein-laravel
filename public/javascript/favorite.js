$('.addProductFavorite').click(function(e) {
    e.preventDefault();
    const route = $(this).data('route');
    const productId = $(this).data('product-id');
    const totalQuantityFavorite = $('#totalQuantityFavorite');
    
    $.ajax({
        url: route,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            product_id: productId,
        },
        success: function(response) {
            console.log(response);
            
            totalQuantityFavorite.text("("+response.totalProductFavorite+")")
            toastr.options = {
                "progressBar": true,
                "closeButton": true,
            }
            if(response.success) {
                toastr.success(response.success, "Thành công", {timeOut: 4000 });
            }
            if(response.warning) {
                toastr.warning(response.warning, "Thông báo", {timeOut: 4000 });
            }
            else {
                toastr.eror(response.error, "Thất bại", {timeOut: 3000 });
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText); // Để xem lỗi
        }
    })

})