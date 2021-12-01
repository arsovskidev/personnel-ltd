<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Method for sending JSON response to prevent DRY.
    public function sendResponse($status, $data = [], $code)
    {
        $response = [
            'status' => $status,
            'data' => $data,
        ];

        return response()->json($response, $code);
    }
}
