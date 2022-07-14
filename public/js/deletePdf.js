$(document).ready(function () {

});

function deletePdf(inId) {
    $.ajax({
        url: _dir + '/devices/pdf/' + inId.toString(),
        type: "DELETE",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (d) {
            if (d.success == true){
                $("#pdfPathLabel").remove();
                $("#pdf_path").removeClass("d-none");
            }
        },
        error: function (e) {
            console.error(e);
        }
    });
}
