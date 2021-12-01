@extends('layouts.master')

@section('title', 'Personnel LTD | Users')

@section('body')

    <body id="body-base">
        {{-- Including navbar. --}}
        @include('components.navbar')
        <div>
            <section class="content-section">
                <div class="container-fluid">
                    <h1 class="fw-normal">Users</h1>
                    <div class="my-5">
                        <div class="container">
                            <div class="row">
                                {{-- Table for users. --}}
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-body table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Full Name</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($users))
                                                        @foreach ($users as $user)
                                                            <tr>
                                                                <td>{{ $user->id }}</td>
                                                                <td>{{ $user->name }}</td>
                                                                <td>
                                                                    <a href="{{ route('users.show', $user->id) }}"
                                                                        class="btn btn-light btn-sm">View</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            {{-- Pagination. --}}
                                            <div class="d-flex justify-content-center">
                                                {!! $users->links() !!}
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
    </body>
@endsection
