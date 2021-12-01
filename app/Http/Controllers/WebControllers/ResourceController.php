<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Exports\CallsExport;
use App\Imports\CallsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ResourceController extends Controller
{
    /**
     * Return a view for the import/export page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View
     */
    public function index()
    {
        return view('resources.index');
    }

    /**
     * Import resources to storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        // Save all the request in @var $input.
        $input = $request->all();

        // Create an array for the validation rules.
        $rules = [
            'file' => 'required|mimes:csv',
        ];

        // Make the validation.
        $validator = Validator::make($input, $rules);

        // If the validation fails to return back a response with status 400 and message for the error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // If the importing was successful return back a response with status 200 and message.
        if (Excel::import(new CallsImport, $request->file('file')->store('temp'))) {
            return response()->json('File successfully imported.', 200);
        }
    }

    /**
     * Export all resources from storage.
     */
    public function export()
    {
        return Excel::download(new CallsExport, 'calls.csv');
    }
}
