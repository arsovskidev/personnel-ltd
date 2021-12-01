@extends('layouts.master')

@section('title', 'Personnel LTD')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js">
    </script>
    <script src="{{ asset('js/moment.js') }}"></script>
@endsection

@section('body')

    <body id="body-base">
        {{-- Including navbar. --}}
        @include('components.navbar')
        <div>
            <section class="content-section">
                <div class="container-fluid">
                    <h1 class="fw-normal">Calls <i class='btn-create-call-modal bx bx-plus text-blue'></i>
                    </h1>
                    <div class="my-5">
                        <div class="container">
                            <div class="row">
                                {{-- Table for all valid calls. --}}
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-body table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>User</th>
                                                        <th>Client</th>
                                                        <th>Client Type</th>
                                                        <th>Type</th>
                                                        <th>Duration</th>
                                                        <th>Score</th>
                                                        <th>Date</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($valid_calls))
                                                        @foreach ($valid_calls as $call)
                                                            <tr>
                                                                <td>{{ $call->id }}</td>
                                                                <td>{{ $call->user->name }}</td>
                                                                <td>{{ $call->client->name }}</td>
                                                                <td>{{ $call->client->type }}</td>
                                                                <td>{{ $call->type }}</td>
                                                                <td>{{ $call->duration }}</td>
                                                                <td>{{ $call->score }}</td>
                                                                <td>{{ $call->date }}</td>
                                                                <td class="text-center">
                                                                    <i class='btn-edit-call bx bx-edit-alt mx-1'></i>
                                                                    <i class='btn-delete-call bx bx-trash-alt mx-1'
                                                                        data-url='{{ route('calls.destroy', $call->id) }}'></i>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            {{-- Pagination. --}}
                                            <div class="d-flex justify-content-center">
                                                {!! $valid_calls->links() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        {{-- Creating new call Modal. --}}
        <div id="create_call_modal">
            <div class="card">
                <form id="create_call_form" action="#" method="POST" class="card-form">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user">User</label>
                                <select class="form-control" id="user">
                                    @if (count($users))
                                        <option selected disabled value="0">Please select one user...</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    @else
                                        <option selected disabled value="0">There are no users in database, try importing
                                            first.
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client">Client</label>
                                <select class="form-control" id="client" required>
                                    @if (count($clients))
                                        <option selected disabled value="0">Please select one client...</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    @else
                                        <option selected disabled value="0">There are no clients in database, try importing
                                            first.
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select class="form-control" id="type">
                                    <option value="Incoming">Incoming</option>
                                    <option value="Outgoing">Outgoing</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input">
                                <input type="number" id="duration" class="input-field" placeholder=" " />
                                <label class="input-label">Duration</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input">
                                <input type="number" id="score" class="input-field" placeholder=" " />
                                <label class="input-label">Score</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="input">
                                <input type="text" name="date" id="date" class="input-field"
                                    placeholder="2014-12-08 15:43:00">
                            </div>
                            <div class="text-muted">Enter date in this format, or leave it blank for current date.</div>
                        </div>
                    </div>
                    <div class="action">
                        <button class="btn-action btn-create-call-submit py-2">Create</button>
                    </div>
                </form>
            </div>
        </div>
        <script src="{{ asset('js/table-buttons.js') }}"></script>
        <script>
            $("#create_call_modal").iziModal();

            $(document).on('click', '.btn-create-call-modal', function(event) {
                $('#create_call_modal').iziModal('open');
            });

            $(document).on('click', '.btn-create-call-submit', function(event) {
                event.preventDefault();

                // Getting the form data.
                let user = $('#user').val();
                let client = $('#client').val();
                let type = $('#type').val();
                let duration = $('#duration').val();
                let score = $('#score').val();
                let date = $('#date').val();

                // Check if date is empty, if it is get the current date and time in YYYY-MM-DD HH:mm:ss format using the Moment.js library.
                if (date === "") {
                    date = moment().format('YYYY-MM-DD HH:mm:ss');
                }

                $.ajax({
                    url: '{{ route('calls.store') }}',
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
                    $('#user').val(0);
                    $('#client').val(0);
                    $('#duration').val('');
                    $('#score').val('');
                    $('#date').val('');

                    // Foreach all call data and append it to a string.
                    let new_table_row = '';

                    $.each(data.data.call, function(index, value) {
                        new_table_row += `<td>${value}</td>`;
                    });

                    // Create the url for deleting this call.
                    let delete_url = "{{ route('calls.destroy', 'id') }}";
                    delete_url = delete_url.replace('id', data.data.call.id);

                    new_table_row +=
                        `<td class="text-center">
                        <i class='btn-edit-call bx bx-edit-alt mx-1'></i>
                        <i class='btn-delete-call bx bx-trash-alt mx-1'data-url='${delete_url}'></i>
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
        </script>
    </body>

@endsection
