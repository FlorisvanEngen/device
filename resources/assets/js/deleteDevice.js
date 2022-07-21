$(document).ready(function () {
    $("button[type=button].delete-device").on("click", function () {
        let id = $(this).attr("data-id");
        let name = $(this).attr("data-name");

        console.log(id);
        console.log(name);

        $("#deviceId").html(id);
        $("#deviceName").html(name);
        $("#deleteDeviceModal").modal("show");

        $("#deviceDeleteButton").off("click");
        $("#deviceDeleteButton").attr("data-id", id);
        $("#deviceDeleteButton").on("click", function () {
            $(this).off("click");
            let id = $(this).attr("data-id");
            $("#deleteDevice").attr("action", _dir + "/devices/" + id);
            $("#deleteDevice").submit();
        });
    });
});
