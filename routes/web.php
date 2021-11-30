<?php

use App\Http\Controllers\CallController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('calls.index');
});

Route::prefix('calls')->group(function () {
    Route::get('/',                 [CallController::class, 'index'])->name('calls.index');
    Route::get('/import-export',    [CallController::class, 'importExport'])->name('calls.import_export');
    Route::post('/import',          [CallController::class, 'import'])->name('calls.import');
    Route::get('/export',           [CallController::class, 'export'])->name('calls.export');
});
