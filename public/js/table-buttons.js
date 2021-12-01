$(document).on("click", ".btn-delete-call", function() {
    // Getting the url with id from the data-url attribute.
    let url = $(this).data("url");
    // Getting the table row.
    let table_row = $(this).parent().parent();
    $.confirm({
        title: 'Are you sure?',
        content: "Please confirm that you want to delete this call. You can't undo this action.",
        type: 'blue',
        backgroundDismiss: true,
        typeAnimated: false,
        animateFromElement: false,
        theme: 'material',
        animation: 'scale',
        buttons: {
            confirm: function() {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                }).done(function(data) {
                    // If the call deleted, display success notification with iziToast.
                    iziToast.success({
                        title: 'Success',
                        message: data.data.message,
                    });
                    // Removing the table row.
                    table_row.fadeOut();
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    // If there is an error, display notification with iziToast.
                    iziToast.error({
                        title: 'Error',
                        message: jqXHR.responseJSON.data.message,
                    });
                });
            },
            cancel: function() {},
        }
    });
})