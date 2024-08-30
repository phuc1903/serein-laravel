$(document).ready(function () {
    $("#discount_type").change(function() {
        updateDiscountFields();
    })

    updatePriceVoucher();
    updateTotalPrice();

    $('#delete-voucher').click(function() {
        $route = $(this).data('route');
        $voucher = $(this).data('voucher');

        console.log(route, voucher);
        

        // $.ajax({
        //     url: route,
        //     method: "DELETE",
        //     data: {
        //         _token: $('meta[name="csrf-token"]').attr('content'),
        //         codeVoucher
        //     },
        //     dataType: "json",
        //     success: function (response) {}
        // })
    })

    $("#applyVoucher").click(function() {
        const codeVoucher = $("#codeVoucher").val();
        const route = $(this).data('route');

        toastr.options = {
            "progressBar": true,
            "closeButton": true,
        };

        const voucher = JSON.parse(sessionStorage.getItem('voucher'));

        if(voucher) {
            toastr.info("Bạn đã thêm voucher này rồi", "Lưu ý", { timeOut: 4000 })
            return; 
        };
        
        
        $.ajax({
            url: route,
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                codeVoucher
            },
            dataType: "json",
            success: function (response) {
                
                if (response.success) {
                    sessionStorage.setItem('voucher', JSON.stringify(response.voucher));

                    
                    
                    updatePriceVoucher();

                    updateTotalPrice(voucher);

                    toastr.success(response.message, "Thành công", { timeOut: 4000 });
                } else {
                    toastr.error(response.message, "Thất bại", { timeOut: 2000 });
                }
            },
            error: function (xhr, status, error) {
                toastr.error("Có lỗi xảy ra khi áp dụng voucher. Vui lòng thử lại sau.", "Lỗi", { timeOut: 2000 });
            }
        });
    });
});

function updateDiscountFields() {
    const discountType = $('#discount_type').val();
    
    const discountLabel = $('label[for="discount_value"]');

    if (discountType === 'percent') {
        discountLabel.text('Giá trị giảm giá (%)');
        $('#discount_value').attr('placeholder', 'Nhập giá trị giảm giá (%)');
    } else {
        discountLabel.text('Giá trị giảm giá (VNĐ)');
        $('#discount_value').attr('placeholder', 'Nhập giá trị giảm giá (VNĐ)');
    }
}

function updatePriceVoucher(priceVoucher = 0) {
    const voucher = JSON.parse(sessionStorage.getItem('voucher'));
    
    if (voucher) {
        const priceSaleVoucher = parseFloat(voucher.discount_value);
        const valuInputVoucher = $('#codeVoucher');

        let priceVoucherText = $(".price_voucher");
        
        valuInputVoucher.val(voucher['code']);
        priceVoucherText.text(priceSaleVoucher.toLocaleString('vi-VN'));
    }
    
    if (priceVoucher) {
        return priceVoucher.toLocaleString('vi-VN');
    }
}


function updateTotalPrice(totalPriceValue = 0, voucher = null) {
    let totalPriceText = $(".price-total");
    let totalPrice = 0;

    if(totalPriceValue > 0) {
        totalPrice = totalPriceValue;
    } else {
        totalPrice = parseFloat(totalPriceText.text().replace(/\./g, '').replace(/,/g, ''));
    }

    if(voucher === null) {
        voucher = JSON.parse(sessionStorage.getItem('voucher'));
    } else {
        voucher = JSON.parse(voucher);
    }
    
    let total = totalPrice;

    if (voucher) {
        if (voucher['discount_type'] === "amount") {
            total -= parseFloat(voucher['discount_value']);
        } else if (voucher['discount_type'] === "percent") {
            total -= (total * (parseFloat(voucher['discount_value']) / 100));
        }
    }

    total = Math.max(total, 0);

    totalPriceText.text(total.toLocaleString('vi-VN'));

    return total;
}



