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