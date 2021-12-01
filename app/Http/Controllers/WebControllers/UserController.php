<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all users with pagination.
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get the user by the param ID.
        $user = User::find($id);

        // Check if the user exists.
        if ($user != null) {
            // Valid calls are considered valid if the duration is greater than 10.
            // Get the valid calls, order by date DESC and limit only 5.
            $valid_calls = $user->calls()
                ->where('duration', '>', 10)
                ->orderByDesc('date')
                ->limit(5)
                ->get();

            // Get the average score from only valid calls which belongs to this user.
            $avg_score = $user->calls()->where('duration', '>', 10)->avg('score');

            // Round the average score to 2.
            $avg_score = round($avg_score, 2);

            // Get all users and clients and compact them to the view for the dropdown/options select.
            $users = User::all();
            $clients = Client::all();

            return view('users.show', compact('user', 'valid_calls', 'avg_score', 'users', 'clients'));
        }

        return redirect()->route('users.index');
    }
}
