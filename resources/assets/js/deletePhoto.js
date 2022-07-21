$(document).ready(function () {
    $("button[type=button].delete-img").on("click",function (){
        let id = $(this).attr("data-id");

        $.ajax({
            url: _dir + '/devices/photo/' + id.toString(),
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
    });
});
