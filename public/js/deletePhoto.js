function deletePhoto(inId) {
    $.ajax({
        url: _dir + '/devices/photo/' + inId.toString(),
        type: "DELETE",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (d) {
            if (d.success == true){
                $("#photo" + d.photoId.toString()).remove();
            }
        },
        error: function (e) {
            console.error(e);
        }
    });
}
