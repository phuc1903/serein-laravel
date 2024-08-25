function chooseImage() {
    document.getElementById('typeFile').click();
}

function chooseBackground() {
    var input = document.getElementById('backgroundInput');
    input.click();
}


function previewImage(input) {
    var preview = document.getElementById('avatar');
    var file = input.files[0];
    
    if (file) {
        var reader = new FileReader();
        reader.onloadend = function () {
            preview.src = reader.result;
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = 'Public/img/default.jpg?t=' + new Date().getTime();
    }
}

function previewBackground(input) {
    var preview = document.getElementById('avatarImage');
    var file = input.files[0];
    
    if (file) {
        var reader = new FileReader();
        reader.onloadend = function () {
            preview.src = reader.result;
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = 'Public/img/default.jpg?t=' + new Date().getTime();
    }
}


function changeImage(thumbnail) {
    var newSrc = thumbnail.src;

    document.querySelector('.img-main').src = newSrc;

    var thumbnailsItems = document.querySelectorAll('.thumbnails-item');
    thumbnailsItems.forEach(function(item) {
        item.classList.remove('active');
    });

    thumbnail.classList.add('active');
}

function handleThumbnailClick(event) {
    event.stopPropagation();
}

$(document).ready(function() {
    $('.delete-voucher').click(function() {
        const route = $(this).data('route');
        const voucherUserId = $(this).data('voucher-user');
        Swal.fire({
            title: 'Bạn có chắc muốn xóa Voucher này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
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
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        voucherUserId
                    },
                    success: function (response) {
                        toastr.options = {
                            "progressBar": true,
                            "closeButton": true,
                        }
                        if(response.success) {
                            toastr.success(response.message, "Xóa thành công", {timeOut: 4000 });
                        }
                        else {
                            toastr.error(response.message, "Xóa thất bại", {timeOut: 3000 });
                        }

                        location.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText); 
                    }
                });
            }
        })
    })
})