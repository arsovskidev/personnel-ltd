$("#create_call_modal").iziModal();

$(document).on('click', '.btn-create-call-modal', function(event) {
    $('#create_call_modal').iziModal('open');
});
// Create new call.
$(document).on('click', '.btn-create-call-submit', function(event) {
    event.preventDefault();

    // Getting the form data.
    let user = $('#create_user').val();
    let client = $('#create_client').val();
    let type = $('#create_type').val();
    let duration = $('#create_duration').val();
    let score = $('#create_score').val();
    let date = $('#create_date').val();

    // Check if date is empty, if it is get the current date and time in YYYY-MM-DD HH:mm:ss format using the Moment.js library.
    if (date === "") {
        date = moment().format('YYYY-MM-DD HH:mm:ss');
    }

    $.ajax({
        url: root + '/calls/',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            user: user,
            client: client,
            type: type,
            duration: duration,
            score: score,
            date: date,
        }
    }).done(function(data) {
        // Reset the form inputs to default.
        $('#create_user').val(0);
        $('#create_client').val(0);
        $('#create_duration').val('');
        $('#create_score').val('');
        $('#create_date').val('');

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

        // Prepend the table row to the table.
        $(".table>tbody").prepend(`<tr>${new_table_row}</tr>`);

        // Display success notification.
        iziToast.success({
            title: 'Success',
            message: data.data.message,
        });
        $('#create_call_modal').iziModal('close');
    }).fail(function(jqXHR, textStatus, errorThrown) {
        // Display error notification.
        iziToast.error({
            title: 'Error',
            message: jqXHR.responseJSON.data.message,
        });
    });
});