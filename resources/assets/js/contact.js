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
                    let deviceOptions = '<option value="-1" selected disabled>Select a device</option>';
                    d.devices.forEach(function (value) {
                        deviceOptions += `<option value="${value.id}">${value.name}</option>`;
                    });

                    $("#device_id").html(deviceOptions);
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
