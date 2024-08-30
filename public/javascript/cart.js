// function CheckQuantity(quantity) {
//     var inputElement = $(quantity);
//     var inputValue = inputElement.val();

//     var numericValue = inputValue.replace(/\D/g, '');

//     inputElement.val(numericValue);

//     var num = parseInt(numericValue);

//     if(inputValue == "") {
//         inputElement.val(1);
//     }

//     if (isNaN(num) || num <= 0) {
//         inputElement.val();
//         alert("Bạn chỉ được nhập số và số phải lớn hơn 0");
//     }

//     var defaultQuantity = parseInt(inputElement.data('default-quantity'));

//     if (num > defaultQuantity) {
//         inputElement.val(defaultQuantity);
//     }
// }


// function PreQuantity(element) {
//     var inputElement = $(element).closest('.choice__quantity').find('.input-quantity-cart');
//     var quantity = parseInt(inputElement.val());

//     var defaultQuantity = parseInt(inputElement.data('default-quantity'));

//     if (quantity > defaultQuantity - 1) {
//         alert("Sản phẩm đã giới hạn số lượng của kho");
//         inputElement.val(defaultQuantity);
//     }
//     var productId = inputElement.data('id');

//     var data = {
//         'product_id' : productId,
//         'quantity' : quantity
//     }

//     $.ajax({
//         type: "POST",
//         url: "/serein/cart/quantity/subtract",
//         data: data,
//         dataType: "json",
//         success: function (response) {
//             // inputElement.val(response.cart_quantity);
//             // console.log(response);
//             if(response.success) {
//                 $('#carts').html(response.html);
//             }
//         }
//     });
// }

// function AddQuantity(element) {
//     var inputElement = $(element).closest('.choice__quantity').find('.input-quantity-cart');
//     var quantity = parseInt(inputElement.val());

//     var defaultQuantity = parseInt(inputElement.data('default-quantity'));

//     if (quantity > defaultQuantity - 1) {
//         alert("Sản phẩm đã giới hạn số lượng của kho");
//         inputElement.val(defaultQuantity);
//     }
//     var productId = inputElement.data('id');

//     var data = {
//         'product_id' : productId,
//         'quantity' : quantity
//     }

//     $.ajax({
//         type: "POST",
//         url: "/serein/cart/quantity/add",
//         data: data,
//         dataType: "json",
//         success: function (response) {
//             // inputElement.val(response.cart_quantity);
//             // console.log(response);
//             if(response.success) {
//                 $('#carts').html(response.html);
//             }
//         }
//     });
// }

$('.btn-pay').click(function (e) { 
    e.preventDefault();
    const route = $(this).data('route');
    const type = $(this).attr('name');
    const voucher = sessionStorage.getItem('voucher') ? JSON.parse(sessionStorage.getItem('voucher')) : null;
    const user = parseFloat($(this).data('user-id'));

    console.log(!isNaN(user));

    if(!isNaN(user)) {
        Swal.fire({
            title: `Bạn đồng ý thanh toán hóa đơn này bằng ${type.toUpperCase()}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Không đồng ý',
            customClass: {
                popup: 'swal2-custom-size',
                text: "swal2-text-height",
            }
        }).then((result) => { 
            
            if(result.isConfirmed) {
                
                let data = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    type: type,
                }
                if(voucher !== null) {
                    data.voucher = voucher
                }
                $.ajax({
                    type: "POST",
                    method: "POST",
                    data: data,
                    url: route,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        
                        if(response.success) {
                            if(response.payUrl) {
                                window.location.href = response.payUrl;
                            } 
                            else {
                                location.reload();
                            }
                            Swal.fire({
                                title: 'Thành công!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'Đóng'
                            })
                        } else {
                            Swal.fire({
                                title: 'Thất bại!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'Đóng'
                            });
            
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 302) {
                            // Nếu người dùng không được xác thực
                            Swal.fire({
                                title: 'Lỗi!',
                                text: 'Phiên đăng nhập của bạn đã hết hạn, vui lòng đăng nhập lại.',
                                icon: 'error',
                                confirmButtonText: 'Đăng nhập'
                            }).then(() => {
                                window.location.href = '/login';
                            });
                        } 
                        else if(xhr.status === 403) {
                            Swal.fire({
                                title: 'Lỗi!',
                                text: 'Bạn cần xác minh tài khoản để thực hiện thanh toán.',
                                icon: 'error',
                                confirmButtonText: 'Xác minh ngay'
                            }).then(() => {
                                window.location.href = '/email/verify'; // Đường dẫn để người dùng xác minh tài khoản
                            });
                        }
                        else {
                            // Xử lý lỗi khác
                            Swal.fire({
                                title: 'Lỗi!',
                                text: 'Có lỗi xảy ra, vui lòng thử lại.',
                                icon: 'error',
                                confirmButtonText: 'Đóng'
                            });
                        }
                    }
                })
            }
        })
    } 
    else {
        Swal.fire({
            title: 'Thất bại',
            text: 'Vui lòng đăng nhập để thanh toán.',
            icon: 'error',
            confirmButtonText: 'Đóng'
        });
    }
});



$('.choice__remove').click(function() {
    var route = $(this).data('route');
    var productId = $(this).closest('.product__item').data('product-id'); // Lấy id sản phẩm

    Swal.fire({
        title: 'Bạn có chắc muốn xóa?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        customClass: {
            popup: 'swal2-custom-size',
            text: "swal2-text-height",
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: route,
                method: "DELETE",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data) {
                    if(data.success) {
                        $(`.product__item[data-product-id="${productId}"]`).remove();
                            var itemCount = data.newCarts.length;
                            const voucher = sessionStorage.getItem('voucher'); // Lấy từ sessionStorage
                            let carts = [
                                ...Object.values(data.newCarts)
                            ];
                            $('#totalQuantityCart').text("(" + data.totalQuantity + ")");

                            let priceProducts = 0;

                            carts.forEach(cart => {
                                priceProducts += Number(cart.quantity) * cart.price;
                            });
                            $(".total-price-product").text(priceProducts.toLocaleString('vi-VN'));

                            let totalPrice = priceProducts + 18000; // Cộng phí giao hàng

                            // Cập nhật tổng giá trị sau khi áp dụng voucher
                            var finalTotal = updateTotalPrice(totalPrice, voucher);

                            console.log(finalTotal);

                            if(itemCount <= 0) {
                                $('.cart-null').text('Giỏ hàng rỗng');
                            }
                        Swal.fire({
                            title: data.message,
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            customClass: {
                                popup: 'swal2-custom-size',
                                text: "swal2-text-height",
                            }
                        })
                    }
                }
            })
        }
    });
});


$('.addProductCart').click(function(e) {
    e.preventDefault();
    const route = $(this).data('route');
    const productId = $(this).data('product-id');
    let quantity;
    if (Number($('#quantityProductDetail').val()) === 1) {
        quantity = Number($('#quantityProductDetail').val());
    } else {
        quantity = Number($(this).data('quantity')) ? Number($(this).data('quantity')) : 1;
    }

    const totalQuantityCart = $('#totalQuantityCart');

    $.ajax({
        url: route,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            product_id: productId,
            quantity: quantity
        },
        success: function(response) {
            totalQuantityCart.text("(" +response.totalQuantityCart + ")")
            if(response.success) {
                toastr.options = {
                    "progressBar": true,
                    "closeButton": true,
                }
                toastr.success(response.success, "Thành công", {timeOut: 4000 });
            }
            else {
                toastr.options = {
                    "progressBar": true,
                    "closeButton": true,
                }
                toastr.eror(response.success, "Thất bại", {timeOut: 4000 });
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText); // Để xem lỗi
        }
    })
})

$('.BuyProduct').click(function(e) {
    e.preventDefault();
    const route = $(this).data('route');
    const productId = $(this).data('product-id');
    const quantity = Number($(".quantity-input").length) ? Number($('.quantity-input').val()) : 1;

    $.ajax({
        url: route,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            product_id: productId,
            quantity: Number(quantity)
        },
        success: function(response) {
            if(response.success) window.location.href = "/cart";     
        },
        error: function(xhr) {
            console.log(xhr.responseText); // Để xem lỗi
        }
    })
})
