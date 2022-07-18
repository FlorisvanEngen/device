$(document).ready(function () {
    // console.log(devices);
});

var dragging, draggedOver;

function dragStart(event) {
    dragging = event.target.id;
}

function allowDrop(event) {
    event.preventDefault();
    draggedOver = $(event.target).parent("tr").attr("id");
}

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

        dragging = null;
        draggedOver = null;
    }
}

function saveOrder() {
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
            if (d.success == true){
                window.location = _dir + "/devices";
            }
        },
        error: function (e) {
            console.error(e);
        }
    });
}

