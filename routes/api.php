<?php
use App\Http\Controllers\DataIndukController;
use App\Http\Controllers\API\rfidController;
use App\Http\Controllers\API\deviceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API untuk Mengirim Data Jurusan
Route::get('/akademik/jurusan',[DataIndukController::class,'APIJurusan']);
Route::get('/rfid',[rfidController::class,'rfidAPI'])->name('rfidAPI');
Route::get('/rfid/data',[rfidController::class,'rfidData'])->name('rfidData');
Route::get('/absent/entry',[rfidController::class,'rfidadd'])->name('rfidadd');

Route::get('/device/check',[deviceController::class,'cekLisensi'])->name('cekLisensi');
Route::get('/process-rfid', [rfidController::class, 'processRfid'])->name('processRfid');

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

