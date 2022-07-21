$(document).ready(function () {
    var blockSave = false;
    var dragging, draggedOver;

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
        event.preventDefault();

        if (dragging != null && draggedOver != null) {
            let draggingHtml = $("#" + dragging).prop('outerHTML')
            $("#" + dragging).addClass("old");
            $("#" + draggedOver).after(draggingHtml);
            $("#" + dragging + ".old").remove();

            let draggingId = dragging.replace(/device_/g, "");
            let draggedOverId = draggedOver.replace(/device_/g, "");

            let device = devices.find(device => device.id === draggingId);
            let draggingIndex = devices.findIndex(device => device.id === draggingId);
            devices.splice(draggingIndex, 1);

            let draggedOverIndex = devices.findIndex(device => device.id === draggedOverId);
            devices.splice(draggedOverIndex + 1, 0, device);

            devices.forEach(function (device, index) {
                device.order = index;
                $("#order_" + device.id).html(index);
            });

            $("#" + dragging).on("dragstart", function (event) {
                dragging = event.target.id;
            });

            $("#" + dragging).on("dragover", function (event) {
                event.preventDefault();
                draggedOver = $(event.target).parent("tr").attr("id");
            });

            $("#" + dragging).on("drop", function (event) {
                drop(event)
            });

            dragging = null;
            draggedOver = null;
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
                    inDevices: devices
                },
                success: function (d) {
                    if (d.success === true) {
                        window.location = _dir + "/?category=" + categoryId;
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
