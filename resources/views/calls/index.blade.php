@extends('layouts.master')

@section('title', 'Personnel LTD')

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
                                                                    <i class='btn-update-call-modal bx bx-edit-alt mx-1'
                                                                        data-url='{{ route('calls.show', $call->id) }}'
                                                                        data-id='{{ $call->id }}'></i>
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
        @include('components.create_modal')
        {{-- Updating call Modal. --}}
        @include('components.update_modal')
        <script src="{{ asset('js/table-buttons.js') }}"></script>
        <script src="{{ asset('js/create-modal.js') }}"></script>
    </body>

@endsection
