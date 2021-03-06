@extends('layouts.master')

@section('title', 'Personnel LTD | Importing & Exporting')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection

@section('body')

    <body id="body-base">
        {{-- Including navbar. --}}
        @include('components.navbar')
        <div>
            <section class="content-section">
                <div class="container-fluid">
                    <h1 class="fw-normal">Importing & Exporting Calls</h1>
                    <div class="mt-5">
                        <div class="container">
                            <div class="row">
                                {{-- Import Column. --}}
                                <div class="col-md-6 mt-4">
                                    <div class="card">
                                        <div class="card-body text-center" style="height: 350px;">
                                            <div>
                                                <h5 class="card-title">Import</h5>
                                                <i class='bx bx-import text-blue fs-1 mb-5'></i>
                                            </div>
                                            <form id="importForm" action="{{ route('resources.import') }}"
                                                enctype="multipart/form-data" class="dropzone">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- Export Column. --}}
                                <div class="col-md-6 mt-4">
                                    <div class="card">
                                        <div class="card-body text-center" style="height: 350px;">
                                            <div>
                                                <h5 class="card-title">Export</h5>
                                                <i class='bx bx-export text-blue fs-1 mb-5'></i>
                                            </div>

                                            <button id="export" class="btn btn-lg btn-blue">Export Data</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
        <script type="text/javascript">
            // Importing Configuration.
            Dropzone.options.importForm = {
                dictDefaultMessage: "Drop CSV files here to upload, or click me...", // Changing the message of the dropbox.
                paramName: "file", // The name that will be used to transfer the file.
                maxFilesize: 5, // Max file size for upload.
                init: function() {
                    importForm = this;
                    this.on("addedfile", function(file) { // Event when user adds file.
                        // Front-end validation for file type, checks if it is CSV.
                        if (file.type != "text/csv") {
                            // If not CSV, display error notification with iziToast and write message on the uploaded file.
                            $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(
                                'Files of this type are not accepted, only CSV.');
                            iziToast.error({
                                title: 'Error',
                                message: "Files of this type are not accepted, only CSV.",
                            });
                            done();
                        } else {
                            // Display message that the file import is in progress.
                            iziToast.info({
                                title: 'Importing',
                                message: "The file is uploading, stand still and don't refresh the page.",
                            });
                        }
                    });
                    this.on("error", function(file, response) {
                        // Checking the error type.
                        let message = "";
                        if (response.errors) {
                            message = response.errors[0];
                        } else if (response.error) {
                            message = response.error;
                        } else {
                            message = "Importing failed, try again later."
                        }
                        // If there are errors with uploading, display error notification with iziToast and write message on the uploaded file.
                        $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(message);
                        iziToast.error({
                            title: 'Error',
                            message: message,
                        });
                    });
                    this.on("success", function(file, response) {
                        // If the file imported, display success notification with iziToast and write message on the uploaded file.
                        iziToast.success({
                            title: 'Success',
                            message: response,
                        });
                    });

                }
            };
            // Listening on the export button.
            $("#export").on("click", function() {
                // Showing message that the data is being exported and making requests to the export route.
                iziToast.info({
                    title: 'Exporting',
                    message: "The file is generating, stand still and don't refresh the page.",
                });
                window.location = "{{ route('resources.export') }}";
            });
        </script>
    </body>
@endsection
