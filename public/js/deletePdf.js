function deletePdf(inId, inUserId) {
    $.ajax({
        url: _dir + '/devices/pdf/' + inId.toString(),
        data: {'edited_by_id': inUserId},
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
