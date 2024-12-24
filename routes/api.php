<?php
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\JadwalController;
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
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('me', [loginController::class, 'me']);

    Route::get('/chatAdmin', [ChatController::class, 'getChatsByStatus']);
    Route::post('/send-admin', [ChatController::class, 'messageAdmin']);
    Route::put('/chats/{id}/approve', [ChatController::class, 'approveChat']);
    Route::put('/chats/{id}/end', [ChatController::class, 'endChat']);
    
    Route::get('/keuangan', [KeuanganController::class, 'index']);
    Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
});
Route::middleware(['auth:api', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/me', [MahasiswaController::class, 'showAuthenticatedMahasiswa']);
    Route::get('/mahasiswa/jadwal/me', [MahasiswaController::class, 'showAuthenticatedMahasiswaJadwal']);
    Route::get('/mahasiswa/pembayaran/me', [MahasiswaController::class, 'showAuthenticatedMahasiswaPembayaran']);
});

Route::post('/pendaftaran', [MahasiswaController::class, 'store']);
Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show']);
Route::post('/send-message', [ChatController::class, 'messageUser']);
Route::get('/get-messages/{pengirim}', [ChatController::class, 'getMessages']);
Route::post('/buat-chat', [ChatController::class, 'mulaiChat']);

