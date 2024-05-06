function readURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            if (id) {
                $("#previewImg_" + id).attr("src", e.target.result);
            } else {
                $("#previewImg").attr("src", e.target.result);
            }
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$(function () {
    // Multiple images preview in browser
    var imagesPreview = function (input, placeToInsertImagePreview) {
        if (input.files) {
            var filesAmount = input.files.length;

            // Xóa bỏ hình ảnh hiện có trước khi hiển thị ảnh mới
            $(placeToInsertImagePreview).empty();

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function (event) {
                    $($.parseHTML("<div>"))
                        .attr("class", "col-md-3 mb-4")
                        .append(
                            $($.parseHTML("<img>"))
                                .attr("src", event.target.result)
                                .attr("class", "img-thumbnail")
                        )
                        .appendTo(placeToInsertImagePreview);
                };

                reader.readAsDataURL(input.files[i]);
            }
        }
    };

    $("#gallery-photo-add").on("change", function () {
        imagesPreview(this, "div.gallery");
    });
});
