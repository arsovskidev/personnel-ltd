<?php

use App\Http\Controllers\WebControllers\CallController;
use App\Http\Controllers\WebControllers\UserController;
use App\Http\Controllers\WebControllers\ResourceController;
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
    Route::post('/',                [CallController::class, 'store'])->name('calls.store');
    Route::get('/{id}',             [CallController::class, 'show'])->name('calls.show');
    Route::put('/{id}',             [CallController::class, 'update'])->name('calls.update');
    Route::delete('/{id}',          [CallController::class, 'destroy'])->name('calls.destroy');
});

Route::prefix('resources')->group(function () {
    Route::get('/',                 [ResourceController::class, 'index'])->name('resources.index');
    Route::post('/import',          [ResourceController::class, 'import'])->name('resources.import');
    Route::get('/export',           [ResourceController::class, 'export'])->name('resources.export');
});

Route::prefix('users')->group(function () {
    Route::get('/',                 [UserController::class, 'index'])->name('users.index');
    Route::get('/{id}',             [UserController::class, 'show'])->name('users.show');
});
