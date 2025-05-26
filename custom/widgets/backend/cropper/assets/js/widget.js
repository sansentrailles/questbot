var containerSelector = '.container-cropper';
var optionsBlock = '.cropper-options';
var crop = null;

(function() {

    $(".file-uploader").change(function() {
        var container = $(this).closest(containerSelector);

        file = this.files[0];

        render_image(file, container);
    });

    $('.upload-image').on('click', function() {

        var container = $(this).closest(containerSelector);
        var options = container.find(optionsBlock);
        var action = options.find('.action').val() || '' ;



        if(action === '') {
            return false;
        }

        var formData = new FormData();

        var data = crop.cropper("getData");

        var imageData = crop.cropper("getImageData");

        // var width = container.data('width');
        // var height = container.data('height');
        var $prevCropped = container.find('.prev-cropped')

        formData.append('file', file);
        formData.append('prevCroppedFile', $prevCropped.val() || '');

        // var resizeWidth = container.data('resizeWidth');
        // var resizeHeight = container.data('resizeHeight');

        var resizeWidth = getOptions(container, 'resizeWidth') || 0;
        var resizeHeight = getOptions(container, 'resizeHeight') || 0;

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
            url: action,
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            success: function(data)
            {
                if (data.error) {
                    show_error(container, data.error);
                    return;
                }

                show_error(container, '');

                // save cropped file for remove
                if(data.filePath) {
                    $prevCropped.val(data.filePath);

                    var html = "<img src='" + data.filePath + "' class='img-responsive' />";
                    container.find('.result-image-container').html(html);
                    container.find('.file-thumb-upload').val(data.filePath);
                }
            }
        });
    });

}());

var render_image = function(file, container) {
    var reader = new FileReader();
    reader.onload = function(event) {
        var the_url = event.target.result;
        var html = "<img src='" + the_url + "' class='img-responsive crop-img' />";
        container.find('.original-image-container').html(html);
        container.find('.image-widget-manager').show();


        var image = container.find('.crop-img');

        if(getOptions(container, 'withoutCrop') == false) {
            connect_cropper(container, image);
        }
    }

    reader.readAsDataURL(file);
};

var getOptions = function(container, option) {
    var options = container.find(optionsBlock).find('.'+option);

    return options.val() || '';
};

var connect_cropper = function(container, image) {
    crop = image;
    // var width = container.data('crop-width') || 0;
    // var height = container.data('crop-height') || 0;

    var width = getOptions(container, 'cropWidth') || 0;
    var height = getOptions(container, 'cropHeight') || 0;

    // if(withoutCrop) {
    //     return false;
    // }

    if(width === 0 || height === 0)
        aspectRatio = 0;
    else
        aspectRatio = width / height;

    crop = image.cropper({
        aspectRatio: aspectRatio,
        rotatable: true,
        scalable: false,
        crop: function(e) {
            // sizeBlock.text(Math.round(e.width)+"x"+Math.round(e.height)+"px");
        }
    });
};

var show_error = function(container, error) {
    var formGroup = container.find('.form-group');

    if (error === '') {
        formGroup.removeClass('has-error').find('.help-block').text('');
    } else {
        formGroup.addClass('has-error').find('.help-block').text(error);
    }
}