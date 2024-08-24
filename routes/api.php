<?php
use App\Http\Controllers\DataIndukController;
use App\Http\Controllers\rfidController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API untuk Mengirim Data Jurusan
Route::get('/akademik/jurusan',[DataIndukController::class,'APIJurusan']);
// API untuk Menambah Data Jurusan
Route::Post('/akademik/datainduk/tahunajarAdd',[DataIndukController::class,'dataIndukTahunajarAdd'])->name('dataIndukTahunajarAdd');

Route::get('/rfid',[rfidController::class,'rfidAPI'])->name('rfidAPI');
Route::get('/rfid/data',[rfidController::class,'rfidData'])->name('rfidData');
Route::get('/absent/entry',[rfidController::class,'rfidadd'])->name('rfidadd');
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

