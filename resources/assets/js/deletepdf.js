$(document).ready(function () {
    $("button[type=button].delete-pdf").on("click", function () {
        let id = $(this).attr("data-id");
        let userId = $(this).attr("data-userid");

        $.ajax({
            url: _dir + '/devices/pdf/' + id.toString(),
            data: {'edited_by_id': userId},
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (d) {
                if (d.success === true) {
                    $("#pdfPathLabel").remove();
                    $("#pdf_path").removeClass("d-none");
                }
            },
            error: function (e) {
                console.error(e);
            }
        });
    });
});
