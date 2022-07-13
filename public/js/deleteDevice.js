$(document).ready(function () {

});

function deleteDevice(id, name) {
    try {
        $("#deviceId").html(id);
        $("#deviceName").html(name);
        $("#deviceDeleteButton").attr("onclick", "confDeleteDevice(" + id + ")");
        $("#deleteDeviceModal").modal("show");
    } catch (err) {
        console.error(err)
    }
}

function confDeleteDevice(id) {
    try {
        $("#deleteDevice").attr('action', _dir + '/devices/' + id);
        $("#deleteDevice").submit();
    } catch (err) {
        console.error(err);
    }
}
