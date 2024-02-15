<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\QuizeController;
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
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/all-quize', [QuizeController::class, 'all_quize']);
    Route::post('/store-quize', [QuizeController::class, 'store_quize']);
    Route::get('/all-images', [QuizeController::class, 'all_image']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);