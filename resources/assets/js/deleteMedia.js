$(document).ready(function () {
    $("button[type=button].delete-file").on("click", function () {
        let id = $(this).data("id");

        $.ajax({
            url: _dir + '/media/' + id,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (d) {
                if (d.success === true) {
                    if (d.type === "pdf") {
                        $("#pdfPathLabel").remove();
                        $("#pdf").removeClass("d-none");
                    } else {
                        $("#photo" + id).remove();
                    }
                } else {
                    $("#jsErrorToast .toast-body").html(d.errorMsg);
                    $("#jsErrorToast").toast("show");
                }
            },
            error: function (e) {
                console.error(e);
            }
        });
    });
});
