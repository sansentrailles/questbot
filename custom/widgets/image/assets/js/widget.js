var file;
var crop;
var crop_img;
var withoutCrop = 0;
$(document).ready(function() {
    $(".file-uploader").change(function() {
        var container = $(this).closest('.image-widget');
        withoutCrop = container.data('without-crop') || 0;

        file = this.files[0];

        renderImage(file, container);
        container.find('.file-info-name').text(file.name)
        container.find('.file-info-type').text(file.type)
    });

    $('.quality-field').change(function() {
        var container = $(this).closest('.quality-box');
        container.find('.quality-label').text($(this).val());
    });

    $('.upload-image').on('click', function() {
        var container = $(this).closest('.image-widget');
        var action = container.data('action');

        var formData = new FormData();

        var data = crop_img.cropper("getData");

        var imageData = crop_img.cropper("getImageData");

        // var width = container.data('width');
        // var height = container.data('height');
        var $photoField = container.find('.photo-field')
        var $qualityField = container.find('.quality-field');

        formData.append('file', file);
        formData.append('croppedFile', $photoField.val());
        formData.append('quality', $qualityField.val());

        var resizeWidth = container.data('resizeWidth');
        var resizeHeight = container.data('resizeHeight');

        // formData.append('width', width);
        // formData.append('height', height);

        formData.append('resizeWidth', resizeWidth);
        formData.append('resizeHeight', resizeHeight);

        formData.append('naturalWidth', imageData.naturalWidth);
        formData.append('naturalHeight', imageData.naturalHeight);

        formData.append('x', data.x);
        formData.append('y', data.y);
        formData.append('cropWidth', data.width);
        formData.append('cropHeight', data.height);


        $.ajax({
            // url: "/admin/item/upload-file",
            url: action,
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            success: function(data)
            {
                if (data.error) {
                    showError(container, data.error);
                    return;
                }
                showError(container, '');

                if(data.filePath) {
                    $photoField.val(data.filePath);

                    var html = "<img src='" + data.filePath + "' class='img-responsive' />";
                    container.find('.result-image-container').html(html);
                    container.find('.file-thumb-upload').val(data.filePath);

                }
            }
        });

        // console.log(form, formData);
    });
});

var showError = function(container, error) {
    var formGroup = container.find('.form-group');

    if (error == '') {
        formGroup.removeClass('has-error').find('.help-block').text('');
    } else {
        formGroup.addClass('has-error').find('.help-block').text(error);
    }
}

function renderImage(file, container) {
    var reader = new FileReader();
    var progressbar = container.find(".progress-bar");
    var pb_container = progressbar.closest('.progress');

    reader.onprogress = function(event) {
        pb_container.show();
        if (event.lengthComputable) {
            var progress = parseInt( ((event.loaded / event.total) * 100), 10 );
            progressbar.css({'width': progress+'%'});
            progressbar.attr('aria-valuenow', progress);
        }
    };

    reader.onload = function(event) {
        var the_url = event.target.result;
        var html = "<img src='" + the_url + "' class='img-responsive crop-img' />";
        container.find('.image-container').html(html);
        pb_container.hide();
        container.find('.image-widget-manager').show();

        var image = container.find('.crop-img');
        cropperConnection(container, image);
    }

    reader.readAsDataURL(file);
}

function cropperConnection(container, image)
{
    crop_img = image;
    var width = container.data('crop-width') || 0;
    var height = container.data('crop-height') || 0;
    // var withoutCrop = container.data('without-crop') || 0;
    if(withoutCrop) {
        return false;
    }


    if(width === 0 || height === 0)
        aspectRatio = 0;
    else
        aspectRatio = width / height;

    var sizeBlock = container.find('.file-info-size').text('ok');

    crop = image.cropper({
        aspectRatio: aspectRatio,
        rotatable: true,
        scalable: false,
        crop: function(e) {
            sizeBlock.text(Math.round(e.width)+"x"+Math.round(e.height)+"px");
        }
    });
}