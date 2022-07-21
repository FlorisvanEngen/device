function deleteDevice(inId, inName) {
    try {
        $("#deviceId").html(inId);
        $("#deviceName").html(inName);
        $("#deviceDeleteButton").attr("onclick", "confDeleteDevice(" + inId + ")");
        $("#deleteDeviceModal").modal("show");
    } catch (err) {
        console.error(err)
    }
}

function confDeleteDevice(inId) {
    try {
        $("#deviceDeleteButton").removeAttr("onclick");
        $("#deleteDevice").attr("action", _dir + "/devices/" + inId);
        $("#deleteDevice").submit();
    } catch (err) {
        console.error(err);
    }
}
