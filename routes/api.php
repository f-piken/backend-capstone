<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/mahasiswa', [MahasiswaController::class, 'index']);

Route::post('/send-message', [ChatController::class, 'messageUser']);
Route::post('/buat-chat', [ChatController::class, 'mulaiChat']);

Route::post('/send-admin', [ChatController::class, 'messageAdmin']);
Route::get('/get-messages', [ChatController::class, 'getMessages']);

Route::get('/chatAdmin', [ChatController::class, 'index']);
