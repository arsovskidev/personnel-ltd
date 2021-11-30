@extends('layouts.master')

@section('title', 'Personnel LTD')

@section('body')

    <body id="body-base">
        {{-- Including navbar. --}}
        @include('components.navbar')
        <div>
            <section class="content-section">
                <div class="container-fluid">
                    <h1 class="fw-normal">Calls</h1>
                    <div class="mt-5">
                    </div>
                </div>
            </section>
        </div>
    </body>
@endsection
