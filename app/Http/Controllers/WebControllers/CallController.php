<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CallController extends Controller
{
    /**
     * Return a view for the calls page.
     *
     * @return \Illuminate\Contracts\View
     */
    public function index()
    {
        // Valid calls are considered valid if the duration is greater than 10.
        // Paginate the collection.
        $valid_calls = Call::where('duration', '>', 10)
            ->orderByDesc('date')
            ->paginate(10);

        // Get all users and clients and compact them to the view for the dropdown/options select.
        $users = User::all();
        $clients = Client::all();

        return view('calls.index', compact('valid_calls', 'users', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Save all the request in @var $input.
        $input = $request->all();

        // Create an array for the validation rules.
        $rules = [
            'user' => 'required',
            'client' => 'required',
            'type' => 'required',
            'duration' => 'required',
            'score' => 'required',
            'date' => 'date_format:Y-m-d H:i:s',
        ];

        // Make the validation.
        $validator = Validator::make($input, $rules);

        // If the validation fails to return back a response with status 400 and message for the error.
        if ($validator->fails()) {
            return $this->sendResponse("error", ["message" => $validator->errors()->first()], 400);
        }

        // Create the call with the inputs from the request.
        $call = Call::create([
            'user_id' => $input['user'],
            'client_id' => $input['client'],
            'date' => $input['date'],
            'duration' => $input['duration'],
            'type' => $input['type'],
            'score' => $input['score'],
        ]);

        // Returning success message and passing the the new call with relations.
        return $this->sendResponse(
            "success",
            [
                "message" => "Call successfully created.",
                "call" => [
                    'id' => $call->id,
                    'user' => $call->user->name,
                    'client' => $call->client->name,
                    'client_type' => $call->client->type,
                    'type' => $call->type,
                    'duration' => $call->duration,
                    'score' => $call->score,
                    'date' => $call->date,
                ]
            ],
            200,
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get the call by the param ID.
        $call = Call::find($id);
        // Check if the call exists.
        if ($call != null) {
            // Delete call and return response.
            $call->delete();
            return $this->sendResponse("success", ["message" => "Call successfully removed."], 200);
        }
        // If not, return error message.
        return $this->sendResponse("error", ["message" => "There was an error removing this call."], 404);
    }
}
