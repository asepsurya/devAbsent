<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataIndukController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\GTKController;
use App\Http\Controllers\authController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\pengaturanAkademik;

Route::get('/', function () {
    return view('frontpage.index');
});
Route::get('/role',[authController::class,'role'])->name('role');
Route::get('/role/create',[authController::class,'create'])->middleware('role:walikelas');
Route::middleware('guest')->group(function () {
    // route Auth
    Route::get('/login',[authController::class,'loginIndex'])->middleware('guest')->name('login');
    Route::post('/loginAction',[authController::class,'loginAction'])->name('loginAction');
    Route::get('/register',[authController::class,'registerIndex']);
    Route::post('/registerInput',[authController::class,'registerInput'])->name('registerInput');
  
});

Route::middleware('auth')->group(function () {
    // route Dashboard
    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::get('/student/dashboard',[DashboardController::class,'Studentindex']);
    Route::get('/holidays',[HolidaysController::class,'index']);
    // route Absensi
    Route::get('/absensi/student',[AbsensiController::class,'absensiStudent']);
    Route::get('/absensi/teacher',[AbsensiController::class,'absensiTeacher']);
    // route Data Induk
    Route::get('/akademik/datainduk/student',[DataIndukController::class,'dataIndukStudent']);
    Route::post('/akademik/datainduk/studentAdd',[DataIndukController::class,'dataIndukStudentAdd'])->name('dataIndukStudentAdd');

    Route::get('/akademik/datainduk/jurusan',[DataIndukController::class,'dataIndukJurusan']);
    Route::post('/akademik/datainduk/jurusanAdd',[DataIndukController::class,'dataIndukJurusanAdd'])->name('dataIndukJurusanAdd');
    Route::post('/akademik/datainduk/jurusanUpdate',[DataIndukController::class,'dataIndukJurusanUpdate'])->name('dataIndukJurusanUpdate');
    Route::get('/akademik/datainduk/jurusanDelete{id}',[DataIndukController::class,'dataIndukJurusanDelete'])->name('dataIndukJurusanDelete');

    Route::get('/akademik/datainduk/kelas',[DataIndukController::class,'dataIndukkelas']);
    Route::post('/akademik/datainduk/kelasAdd',[DataIndukController::class,'dataIndukkelasAdd'])->name('dataIndukkelasAdd');
    Route::post('/akademik/datainduk/kelasEdit',[DataIndukController::class,'dataIndukkelasEdit'])->name('dataIndukkelasEdit');
    Route::get('/akademik/datainduk/kelasDelete{id}',[DataIndukController::class,'dataIndukkelasDelete'])->name('dataIndukkelasDelete');

    Route::get('/akademik/datainduk/mapel',[DataIndukController::class,'dataIndukMapel']);
    Route::post('/akademik/datainduk/mapelAdd',[DataIndukController::class,'dataIndukMapelAdd'])->name('dataIndukMapelAdd');
    Route::post('/akademik/datainduk/mapelUpdate',[DataIndukController::class,'dataIndukMapelUpdate'])->name('dataIndukMapelUpdate');
    Route::get('/akademik/datainduk/mapelDelete{id}',[DataIndukController::class,'dataIndukMapelDelete'])->name('dataIndukMapelDelete');
    
    Route::get('/akademik/datainduk/tahunajar',[DataIndukController::class,'dataIndukMapelTahunajar'])->name('dataIndukMapelTahunajar');
    Route::Post('/akademik/datainduk/tahunajarAdd',[DataIndukController::class,'dataIndukTahunajarAdd'])->name('dataIndukTahunajarAdd');
    Route::Post('/akademik/datainduk/tahunajarUpdate',[DataIndukController::class,'dataIndukTahunajarUpdate'])->name('dataIndukTahunajarUpdate');
    Route::get('/akademik/datainduk/tahunajarDelete{id}',[DataIndukController::class,'dataIndukTahunajarDelete'])->name('dataIndukTahunajarDelete');

    Route::get('/akademik/pengaturan/mapel',[PengaturanAkademik::class,'pengaturanMapel']);
    Route::post('/akademik/pengaturan/mapelAdd',[PengaturanAkademik::class,'pengaturanMapelAdd'])->name('pengaturanMapelAdd');
    Route::post('/akademik/pengaturan/mapelUpdate',[PengaturanAkademik::class,'pengaturanMapelUpdate'])->name('pengaturanMapelUpdate');
    Route::get('/akademik/pengaturan/mapelDelete{id}',[PengaturanAkademik::class,'pengaturanMapelDelete'])->name('pengaturanMapelDelete');

    // route GTK
    Route::get('/gtk/all',[GTKController::class,'GTKall']);
    Route::post('/gtk/add',[GTKController::class,'GTKadd'])->name('GTKadd');


    Route::get('/gtk/employment_types',[GTKController::class,'employmenttypesIndex']);
    Route::post('/gtk/employment_typesAdd',[GTKController::class,'employmenttypesIndexAdd'])->name('employmenttypesIndexAdd');
    Route::post('/gtk/employment_typesUpdate',[GTKController::class,'employmenttypesIndexUpdate'])->name('employmenttypesIndexUpdate');
    Route::get('/gtk/employment_typesDelete{id}',[GTKController::class,'employmenttypesIndexDelete'])->name('employmenttypesIndexDelete');

    // route Pengguna
    Route::get('/user/administrator',[penggunaController::class,'userAdministratorIndex']);
    Route::post('/user/administratorAdd',[penggunaController::class,'userAdministratorAdd'])->name('userAdministratorAdd');
    Route::get('/user/students',[penggunaController::class,'userStudentsIndex']);
    Route::get('/user/employees',[penggunaController::class,'useremployeesIndex']);
    Route::get('/user/modules',[penggunaController::class,'usermodulesIndex']);
    Route::get('/user/user_privileges',[penggunaController::class,'user_privilegesIndex']);
});
Route::post('/logout',[authController::class,'logout'])->name('logout');
// route Regency Administrasi
Route::post('/getkabupaten',[RegionController::class,'getkabupaten'])->name('getkabupaten');
Route::post('/getkecamatan',[RegionController::class,'getkecamatan'])->name('getkecamatan');
Route::post('/getdesa',[RegionController::class,'getdesa'])->name('getdesa');