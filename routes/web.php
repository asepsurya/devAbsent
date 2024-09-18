<?php

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GTKController;
use App\Http\Controllers\authController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\landingController;
use App\Http\Controllers\lisensiController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\API\rfidController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\pengaturanAkademik;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataIndukController;
use App\Http\Controllers\kelaslistController;
use App\Http\Controllers\verifikasiUserController;

Route::get('/',[landingController::class,'index'])->name('index');
Route::get('/listabsents',[landingController::class,'listabsents'])->name('listabsents');
Route::get('/rfid/data',[rfidController::class,'rfidData'])->name('rfidData');
Route::get('/rfid/dataget',[rfidController::class,'rfidDataGET'])->name('rfidDataGET');

route::get('sss',function(){
    // memberikan Permission
    $user= User::FindorFail(413);
    // $user->givePermissionTo('menu');
    // hapus Permission
    // $user->revokePermissionTo('delete student');

});
Route::get('/role',[authController::class,'role'])->name('role');
Route::get('/role/create',[authController::class,'create'])->middleware('role:walikelas');


Route::middleware('guest')->group(function () {
    // route Auth
    Route::get('/login',[authController::class,'loginIndex'])->middleware('guest')->name('login');
    Route::post('/loginAction',[authController::class,'loginAction'])->name('loginAction');
    Route::get('/register',[authController::class,'registerIndex']);
    Route::post('/registerInput',[authController::class,'registerInput'])->name('registerInput');
    Route::post('/registerInput/teacher',[authController::class,'registerInputTeacher'])->name('registerInputTeacher');
    Route::get('/register/info',[authController::class,'registerinfo'])->name('registerinfo');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile/{id}',[authController::class,'profileIndex'])->name('profileIndex');
    Route::post('/profile/edit/action',[authController::class,'profileUpdate'])->name('profileUpdate');
    Route::post('/profile/edit/imageProfile',[authController::class,'imageProfile'])->name('imageProfile');
    // Role Permision pengguna
    Route::get('/dashboard',[DashboardController::class,'superadmin'])->name('dashboard.superadmin')->middleware(['role:superadmin']);
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard',[DashboardController::class,'index'])->name('dashboard.admin');
    });

    // Role Permision untuk walikelas
    Route::middleware('role:walikelas')->group(function () {
        Route::get('/walikelas/dashboard',[DashboardController::class,'walikelasDashboard'])->name('dashboard.walikelas');
    });
    // Role Permision untuk guru
    Route::middleware('role:guru')->group(function () {
        Route::get('/teacher/dashboard',[DashboardController::class,'teacherDashboard'])->name('dashboard.teacher');
    });
    // Role Permision untuk siswa
    Route::middleware('role:siswa')->group(function () {
        Route::get('/student/dashboard',[DashboardController::class,'Studentindex'])->name('dashboard.student');
    });


    Route::get('/class/list',[kelaslistController::class,'kelaslist'])->name('kelaslist');
    Route::get('/class/list/detail',[kelaslistController::class,'kelaslistdetail'])->name('kelaslistdetail');
    Route::get('/holidays',[HolidaysController::class,'index']);
    // route Absensi
    Route::get('/absensi/student',[AbsensiController::class,'absensiStudent'])->name('absensiStudent');
    Route::post('/absensi/student/add',[AbsensiController::class,'absensiStudentAdd'])->name('absensiStudentAdd');
    Route::get('/absensi/teacher',[AbsensiController::class,'absensiTeacher'])->name('absensiTeacher');
    // route Data Induk
    Route::get('/akademik/datainduk/student',[DataIndukController::class,'dataIndukStudent'])->name('dataIndukStudent');
    Route::get('/akademik/datainduk/student/add',[DataIndukController::class,'dataIndukStudentAddIndex'])->name('dataIndukStudentAddIndex');
    Route::post('/akademik/datainduk/studentAddAction',[DataIndukController::class,'dataIndukStudentAdd'])->name('dataIndukStudentAdd');
    Route::get('/akademik/datainduk/studentEdit/{id}',[DataIndukController::class,'studentEditIndex'])->name('studentEditIndex');
    Route::post('/akademik/datainduk/studentEditAction',[DataIndukController::class,'dataIndukStudentEdit'])->name('dataIndukStudentEdit');
    Route::get('/akademik/datainduk/studentDelete{id}',[DataIndukController::class,'studentDelete'])->name('studentDelete');
    Route::post('/akademik/datainduk/studentImport',[DataIndukController::class,'studentImport'])->name('studentImport');
    Route::get('/akademik/datainduk/student/import',[DataIndukController::class,'studentIndex'])->name('studentIndex');
    Route::get('/akademik/datainduk/studentEksportExcel',[DataIndukController::class,'studentEksportExcel'])->name('studentEksportExcel');

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

    Route::get('/akademik/pengaturan/mapel',[PengaturanAkademik::class,'pengaturanMapel'])->name('pengaturanMapel');
    Route::post('/akademik/pengaturan/mapelAdd',[PengaturanAkademik::class,'pengaturanMapelAdd'])->name('pengaturanMapelAdd');
    Route::post('/akademik/pengaturan/mapelUpdate',[PengaturanAkademik::class,'pengaturanMapelUpdate'])->name('pengaturanMapelUpdate');
    Route::get('/akademik/pengaturan/mapelDelete{id}',[PengaturanAkademik::class,'pengaturanMapelDelete'])->name('pengaturanMapelDelete');

    Route::get('/akademik/pengaturan/subject_teachers',[PengaturanAkademik::class,'subject_teachers'])->name('subject_teachers');
    Route::post('/akademik/pengaturan/subject_teachersUpdate',[PengaturanAkademik::class,'subject_teachersUpdate'])->name('subject_teachersUpdate');

    // rombel
    Route::get('/akademik/pengaturan/rombel',[PengaturanAkademik::class,'PengaturaRombel'])->name('PengaturaRombel');
    Route::post('/akademik/pengaturan/rombelUpdate',[PengaturanAkademik::class,'PengaturaRombelUpdate'])->name('PengaturaRombelUpdate');
    // route walikelas
    Route::get('/akademik/pengaturan/walikelas',[PengaturanAkademik::class,'PengaturanWalikelas'])->name('PengaturanWalikelas');
    Route::post('/akademik/pengaturan/walikelas',[PengaturanAkademik::class,'pengaturanWalikelasAdd'])->name('pengaturanWalikelasAdd');
    // route GTK
    Route::get('/gtk/all',[GTKController::class,'GTKall'])->name('GTKall');
    Route::get('/gtk/add',[GTKController::class,'GTKaddIndex'])->name('GTKaddIndex');
    Route::post('/gtk/addAction',[GTKController::class,'GTKadd'])->name('GTKadd');
    Route::get('/gtk/update/{id}',[GTKController::class,'GTKupdateIndex'])->name('GTKupdateIndex');
    Route::post('/gtk/updateAction',[GTKController::class,'GTKupdate'])->name('GTKupdate');
    Route::get('/gtk/deleteAction{id}',[GTKController::class,'GTKdelete'])->name('GTKdelete');
    Route::post('/gtk/import/index',[GTKController::class,'GTKimportIndex'])->name('GTKimportIndex');
    Route::post('/gtk/import',[GTKController::class,'GTKimport'])->name('GTKimport');
    // route rfid
    Route::get('/rfid',[rfidController::class,'rfid'])->name('rfid');

    Route::get('/rfid/delete{id}',[rfidController::class,'rfidDelete'])->name('rfidDelete');


    Route::get('/device/lisensi',[lisensiController::class,'lisensiIndex'])->name('lisensiIndex');
    Route::get('/device/lisensiGet',[lisensiController::class,'lisensiIndexGet'])->name('lisensiIndexGet');
    Route::get('/device/checkLicense', [LisensiController::class, 'checkExpired']);

    Route::post('/subcribe/payment', [PaymentController::class, 'createCharge']);

    Route::get('/gtk/employment_types',[GTKController::class,'employmenttypesIndex']);
    Route::post('/gtk/employment_typesAdd',[GTKController::class,'employmenttypesIndexAdd'])->name('employmenttypesIndexAdd');
    Route::post('/gtk/employment_typesUpdate',[GTKController::class,'employmenttypesIndexUpdate'])->name('employmenttypesIndexUpdate');
    Route::get('/gtk/employment_typesDelete{id}',[GTKController::class,'employmenttypesIndexDelete'])->name('employmenttypesIndexDelete');

    // route Pengguna
    Route::get('/user/administrator',[penggunaController::class,'userAdministratorIndex'])->name('userAdministratorIndex');
    Route::post('/user/administratorAdd',[penggunaController::class,'userAdministratorAdd'])->name('userAdministratorAdd');
    Route::get('/user/students',[penggunaController::class,'userStudentsIndex']);
    Route::get('/user/employees',[penggunaController::class,'useremployeesIndex']);
    Route::get('/user/modules',[penggunaController::class,'usermodulesIndex']);
    Route::get('/user/permission',[penggunaController::class,'usermodulesPermission'])->name('usermodulesPermission');
    Route::get('/user/user_privileges',[penggunaController::class,'user_privilegesIndex']);

    Route::get('/verifikasiuser',[verifikasiUserController::class,'verifikasiUser']);
    Route::get('/verifikasiuserUpdate{id}',[verifikasiUserController::class,'verifikasiUpdate'])->name('verifikasiUpdate');


});
Route::post('/logout',[authController::class,'logout'])->name('logout');
// route Regency Administrasi
Route::post('/getkabupaten',[RegionController::class,'getkabupaten'])->name('getkabupaten');
Route::post('/getkecamatan',[RegionController::class,'getkecamatan'])->name('getkecamatan');
Route::post('/getdesa',[RegionController::class,'getdesa'])->name('getdesa');
Route::post('/getwalikelas',[RegionController::class,'getwalikelas'])->name('getwalikelas');
