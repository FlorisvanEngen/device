$(document).ready(function () {
    $("#category_id").on("change", function () {
        let id = $(this).val();

        $.ajax({
           url: _dir + '/contact/' + id,
            type: "GET",
            header: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (d) {
                if (d.success === true) {
                    $("#device_id").html(d.deviceOptions);
                    $("#device_id").removeAttr("disabled");
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
