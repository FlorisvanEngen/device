$(document).ready(function () {
    var devices = [];
    var blockSave = false;
    var dragging, draggedOver;

    $.ajax({
        url: _dir + '/devices/order/' + categoryId,
        type: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (d) {
            if (d.success === true) {
                devices = d.device;
            } else {
                $("#jsErrorToast .toast-body").html(d.errorMsg);
                $("#jsErrorToast").toast("show");
            }
        },
        error: function (e) {
            console.error(e);
        }
    });

    $("#deviceOrderTable tr[draggable=true]").on("dragstart", function (event) {
        dragging = event.target.id;
    });

    $("#deviceOrderTable tr[draggable=true]").on("dragover", function (event) {
        event.preventDefault();
        draggedOver = $(event.target).parent("tr").attr("id");
    });

    $("#deviceOrderTable tr[draggable=true]").on("drop", function (event) {
        drop(event)
    });

    function drop(event) {
        try {
            event.preventDefault();

            if (dragging != null && draggedOver != null) {
                let draggingHtml = $("#" + dragging).prop('outerHTML')
                $("#" + dragging).addClass("old");
                $("#" + draggedOver).after(draggingHtml);
                $("#" + dragging + ".old").remove();

                let draggingId = parseInt(dragging.replace(/device_/g, ""));
                let draggedOverId = parseInt(draggedOver.replace(/device_/g, ""));

                let device = devices.find(device => device.id === draggingId);
                let draggingIndex = devices.findIndex(device => device.id === draggingId);
                devices.splice(draggingIndex, 1);

                let draggedOverIndex = devices.findIndex(device => device.id === draggedOverId);
                devices.splice(draggedOverIndex + 1, 0, device);

                devices.forEach(function (device, index) {
                    device.order = index + 1;
                    $("#order_" + device.id).html(index + 1);
                });

                $("#" + dragging).on("dragstart", function (event) {
                    dragging = event.target.id;
                });

                $("#" + dragging).on("dragover", function (event) {
                    event.preventDefault();
                    draggedOver = $(event.target).parent("tr").attr("id");
                });

                $("#" + dragging).on("drop", function (event) {
                    drop(event);
                });

                dragging = null;
                draggedOver = null;
            }
        } catch (e) {
            console.error(e);
        }
    }

    $("button[type=button].save-order").on("click", function () {
        if (!blockSave) {
            blockSave = true;
            $.ajax({
                url: _dir + '/devices/order',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    devices: devices
                },
                success: function (d) {
                    if (d.success === true) {
                        window.location = _dir + "/?category=" + categoryId;
                    } else {
                        $("#jsErrorToast .toast-body").html(d.errorMsg);
                        $("#jsErrorToast").toast("show");
                    }
                    blockSave = false;
                },
                error: function (e) {
                    blockSave = false;
                    console.error(e);
                }
            });
        }
    });
});
