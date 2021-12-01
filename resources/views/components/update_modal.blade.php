<div id="update_call_modal">
    <div class="card">
        <form id="update_call_form" action="#" method="POST" class="card-form">
            <input type="hidden" id="update_call_id">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user">User</label>
                        <select class="form-control" id="update_user">
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
                        <select class="form-control" id="update_client" required>
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
                        <select class="form-control" id="update_type">
                            <option value="Incoming">Incoming</option>
                            <option value="Outgoing">Outgoing</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input">
                        <input type="number" id="update_duration" class="input-field" placeholder=" " />
                        <label class="input-label">Duration</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input">
                        <input type="number" id="update_score" class="input-field" placeholder=" " />
                        <label class="input-label">Score</label>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="input">
                        <input type="text" id="update_date" class="input-field" placeholder="2014-12-08 15:43:00">
                    </div>
                    <div class="text-muted">Enter date in this format, or leave it blank for current date.</div>
                </div>
            </div>
            <div class="action">
                <button class="btn-action btn-update-call-submit py-2">Update</button>
            </div>
        </form>
    </div>
</div>
