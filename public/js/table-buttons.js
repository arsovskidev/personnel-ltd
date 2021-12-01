
const root = window.location.protocol + '//' + window.location.host;

$("#update_call_modal").iziModal();

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

// Render the form inputs from the existing card.
$(document).on('click', '.btn-update-call-modal', function(event) {
    // Getting the url with id from the data-url attribute.
    let url = $(this).data("url");

    $.ajax({
        url: url,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }).done(function(data) {
        $('#update_call_modal').data('id', data.data.call.id);
        $('#update_user').val(data.data.call.user_id);
        $('#update_client').val(data.data.call.client_id);
        $('#update_type').val(data.data.call.type);
        $('#update_duration').val(data.data.call.duration);
        $('#update_score').val(data.data.call.score);
        $('#update_date').val(data.data.call.date);

        $('#update_call_modal').iziModal('open');
    }).fail(function(jqXHR, textStatus, errorThrown) {
        // If there is an error, display notification with iziToast.
        iziToast.error({
            title: 'Error',
            message: jqXHR.responseJSON.data.message,
        });
    });

});

$(document).on('click', '.btn-update-call-submit', function(event) {
    event.preventDefault();

    // Getting the form data.
    let id = $("#update_call_modal").data("id");
    let url =  root + '/calls/' + id;
    url = url.replace('id', id)

    let update_user = $('#update_user').val();
    let update_client = $('#update_client').val();
    let update_type = $('#update_type').val();
    let update_duration = $('#update_duration').val();
    let update_score = $('#update_score').val();
    let update_date = $('#update_date').val();

    // Check if date is empty, if it is get the current date and time in YYYY-MM-DD HH:mm:ss format using the Moment.js library.
    if (update_date === "") {
        update_date = moment().format('YYYY-MM-DD HH:mm:ss');
    }

    $.ajax({
        url: url,
        type: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            user: update_user,
            client: update_client,
            type: update_type,
            duration: update_duration,
            score: update_score,
            date: update_date,
        }
    }).done(function(data) {
        // Reset the form inputs to default.
        $('#update_call_id').val('');
        $('#update_user').val(0);
        $('#update_client').val(0);
        $('#update_type').val('');
        $('#update_duration').val('');
        $('#update_score').val('');
        $('#update_date').val('');

        // Foreach all call data and append it to a string.
        let new_table_row = '';

        $.each(data.data.call, function(index, value) {
            new_table_row += `<td>${value}</td>`;
        });

        // Create the url for deleting and updating this call.
        let url =  root + '/calls/' + data.data.call.id;

        new_table_row +=
            `<td class="text-center">
                <i class='btn-update-call-modal bx bx-edit-alt mx-1' data-url='${url}' data-id='${data.data.call.id}'></i>
                <i class='btn-delete-call bx bx-trash-alt mx-1' data-url='${url}'></i>
            </td>`;

        // Getting the old table row and removing it.
        $(`[data-id="${data.data.call.id}"]`).parent().parent().fadeOut();

        // Prepend the table row to the table.
        $(".table>tbody").prepend(`<tr>${new_table_row}</tr>`);

        // Display success notification.
        iziToast.success({
            title: 'Success',
            message: data.data.message,
        });
        $('#update_call_modal').iziModal('close');
    }).fail(function(jqXHR, textStatus, errorThrown) {
        // Display error notification.
        iziToast.error({
            title: 'Error',
            message: jqXHR.responseJSON.data.message,
        });
    });
});