$(document).ready(function () {
     $(".delete-device").on("click", function () {
        let id = $(this).data("id");
        let name = $(this).data("name");

        $("#deviceId").html(id);
        $("#deviceName").html(name);
        $("#deleteDeviceModal").modal("show");

        $("#deviceDeleteButton").off("click");
        $("#deviceDeleteButton").data("id", id);
        $("#deviceDeleteButton").on("click", function () {
            $(this).off("click");
            let id = $(this).data("id");
            $("#deleteDevice").attr("action", _dir + "/devices/" + id);
            $("#deleteDevice").submit();
        });
    });
});
