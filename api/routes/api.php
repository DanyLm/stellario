<?php

use App\Http\Controllers\Api\V1\StarController;
use App\Http\Controllers\Api\V1\IdocController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Documentation
Route::get('/idoc', [IdocController::class, 'idoc'])->name('app.idoc');

Route::group(['prefix' => 'v1'], function () {
    Route::resource('stars', StarController::class);
    Route::post('/stars/{star}/face', [StarController::class, 'updateFace'])->name('stars.update_face');
});
