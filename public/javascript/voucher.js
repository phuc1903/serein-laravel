$(document).ready(function () {
    $("#discount_type").change(function() {
        updateDiscountFields();
    })
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
