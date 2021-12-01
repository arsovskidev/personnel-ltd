@extends('layouts.master')

@section('title', 'Personnel LTD | ' . $user->name)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
@endsection

@section('body')

    <body id="body-base">
        {{-- Including navbar. --}}
        @include('components.navbar')
        <div>
            <section class="content-section">
                <div class="container-fluid">
                    <h1 class="fw-normal">Summary for {{ $user->name }}</h1>
                    <h3 class="fw-light">Average score is {{ $avg_score }}</h3>
                    <div class="my-5">
                        <div class="container">
                            <div class="row">
                                {{-- Table for user calls. --}}
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script src="{{ asset('js/table-buttons.js') }}"></script>
    </body>
@endsection
