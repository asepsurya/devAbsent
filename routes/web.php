<?php

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GTKController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\authController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\reportController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\barcodeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\landingController;
use App\Http\Controllers\leassonController;
use App\Http\Controllers\lisensiController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\API\rfidController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\pengaturanAkademik;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataIndukController;
use App\Http\Controllers\FileTugasController;
use App\Http\Controllers\inOutTimeController;
use App\Http\Controllers\kelaslistController;
use App\Http\Controllers\AppsConfigController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ExcelPreviewController;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\verifikasiUserController;
use App\Http\Controllers\ClassRoomDetailController;
use App\Http\Controllers\setelanHari\setelanHariController;

Route::get('/',[landingController::class,'index'])->name('index');
Route::get('/listabsents',[landingController::class,'listabsents'])->name('listabsents');
// Route::get('/rfid/data',[rfidController::class,'rfidData'])->name('rfidData');
Route::get('/rfid/dataget',[rfidController::class,'rfidDataGET'])->name('rfidDataGET');


route::get('sss',function(){
    // memberikan Permission
    $user= User::FindorFail(413);
    // $user->class/leasson/view;
    // hapus Permission
    // $user->revokePermissionTo('delete student');

});
Route::get('/role',[authController::class,'role'])->name('role');
Route::get('/role/create',[authController::class,'create'])->middleware('role:walikelas');

// register Route
Route::middleware(['statusRegister'])->group(function () {
    Route::get('/register',[authController::class,'registerIndex']);
});

Route::middleware('guest')->group(function () {
    // route Auth
    Route::get('/login',[authController::class,'loginIndex'])->middleware('guest')->name('login');
    Route::post('/loginAction',[authController::class,'loginAction'])->name('loginAction');
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

    Route::get('/absent/list/{id_kelas}/{nis}',[kelaslistController::class,'absent_list'])->name('absent_list');

    Route::get('/absent/class',[kelaslistController::class,'absentclass'])->name('absentclass');
    Route::get('/absent/class/student',[kelaslistController::class,'absentClassStudent'])->name('absentClassStudent');
    Route::get('/absent/class/presensi/{id}',[kelaslistController::class,'presensiClassStudent'])->name('presensiClassStudent');

    Route::get('/class/list',[kelaslistController::class,'kelaslist'])->name('kelaslist');
    Route::get('/class/list/detail/{id}',[kelaslistController::class,'kelaslistdetail'])->name('kelaslistdetail');
    Route::get('/holidays',[HolidaysController::class,'index']);
    // route Absensi RFID
    Route::get('/absensi/student',[AbsensiController::class,'absensiStudent'])->name('absensiStudent');
    Route::post('/absensi/student/add',[AbsensiController::class,'absensiStudentAdd'])->name('absensiStudentAdd');
    Route::post('/absensi/teacher/add',[AbsensiController::class,'absensiTeacherAdd'])->name('absensiTeacherAdd');
    Route::get('/absensi/teacher',[AbsensiController::class,'absensiTeacher'])->name('absensiTeacher');
    // Route Absensi Kelas
    Route::post('/absensi/class/student',[AbsensiController::class,'absensiClassStudent'])->name('absensiClassStudent');
    Route::get('/class/absensi/management',[AbsensiController::class,'absensiClassManagement'])->name('absensiClassManagement');
    // route Data Induk
    Route::get('/akademik/datainduk/student',[DataIndukController::class,'dataIndukStudent'])->name('dataIndukStudent');
    Route::get('/akademik/datainduk/student/add',[DataIndukController::class,'dataIndukStudentAddIndex'])->name('dataIndukStudentAddIndex');
    Route::post('/akademik/datainduk/studentAddAction',[DataIndukController::class,'dataIndukStudentAdd'])->name('dataIndukStudentAdd');
    Route::get('/akademik/datainduk/studentEdit/{id}',[DataIndukController::class,'studentEditIndex'])->name('studentEditIndex');
    Route::post('/akademik/datainduk/studentEditAction',[DataIndukController::class,'dataIndukStudentEdit'])->name('dataIndukStudentEdit');
    Route::post('/akademik/datainduk/studentfoto',[DataIndukController::class,'dataIndukStudentfoto'])->name('dataIndukStudentfoto');
    Route::get('/akademik/datainduk/studentDelete{id}',[DataIndukController::class,'studentDelete'])->name('studentDelete');
    Route::post('/akademik/datainduk/studentImport',[DataIndukController::class,'studentImport'])->name('studentImport');
    Route::get('/akademik/datainduk/student/import',[DataIndukController::class,'studentIndex'])->name('studentIndex');
    Route::get('/akademik/datainduk/studentEksportExcel',[DataIndukController::class,'studentEksportExcel'])->name('studentEksportExcel');
    Route::get('/akademik/datainduk/studentcard',[DataIndukController::class,'dataIndukStudentCard'])->name('dataIndukStudentCard');
    Route::post('/akademik/datainduk/studentcardmulti',[DataIndukController::class,'dataIndukStudentCardmulti'])->name('dataIndukStudentCardmulti');
    Route::get('/akademik/lulusan',[DataIndukController::class,'lulusan'])->name('dataIndukStudentlulusan');

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

    Route::get('/class/leasson/mapel',[PengaturanAkademik::class,'pengaturanMapel'])->name('pengaturanMapel');
    Route::post('/akademik/pengaturan/mapel/import',[PengaturanAkademik::class,'pengaturanMapelImport'])->name('pengaturanMapelImport');
    Route::post('/akademik/pengaturan/mapelAdd',[PengaturanAkademik::class,'pengaturanMapelAdd'])->name('pengaturanMapelAdd');
    Route::post('/akademik/pengaturan/mapelUpdate',[PengaturanAkademik::class,'pengaturanMapelUpdate'])->name('pengaturanMapelUpdate');
    Route::get('/akademik/pengaturan/mapelDelete{id}',[PengaturanAkademik::class,'pengaturanMapelDelete'])->name('pengaturanMapelDelete');

    Route::get('/class/leasson/subject_teachers',[PengaturanAkademik::class,'subject_teachers'])->name('subject_teachers');
    Route::post('/akademik/pengaturan/subject_teachersUpdate',[PengaturanAkademik::class,'subject_teachersUpdate'])->name('subject_teachersUpdate');

    // rombel
    Route::get('/akademik/pengaturan/rombel',[PengaturanAkademik::class,'PengaturaRombel'])->name('PengaturaRombel');
    Route::get('/akademik/pengaturan/rombel/students',[PengaturanAkademik::class,'dataAwalSiswa'])->name('PengaturaRombel.dataAwalSiswa');
    Route::get('/akademik/pengaturan/rombel/togetstudents',[PengaturanAkademik::class,'dataTujuanSiswa'])->name('PengaturaRombel.dataTujuanSiswa');
    Route::post('/akademik/pengaturan/rombelUpdate',[PengaturanAkademik::class,'PengaturaRombelUpdate'])->name('PengaturaRombelUpdate');
    // route walikelas
    Route::get('/akademik/pengaturan/walikelas',[PengaturanAkademik::class,'PengaturanWalikelas'])->name('PengaturanWalikelas');
    Route::post('/akademik/pengaturan/walikelasAdd',[PengaturanAkademik::class,'pengaturanWalikelasAdd'])->name('pengaturanWalikelasAdd');
    Route::post('/akademik/pengaturan/walikelasEdit',[PengaturanAkademik::class,'pengaturanWalikelasEdit'])->name('pengaturanWalikelasEdit');
    // route GTK
    Route::get('/gtk/all',[GTKController::class,'GTKall'])->name('GTKall');
    Route::get('/gtk/add',[GTKController::class,'GTKaddIndex'])->name('GTKaddIndex');
    Route::post('/gtk/addAction',[GTKController::class,'GTKadd'])->name('GTKadd');
    Route::get('/gtk/update/{id}',[GTKController::class,'GTKupdateIndex'])->name('GTKupdateIndex');
    Route::post('/gtk/updateAction',[GTKController::class,'GTKupdate'])->name('GTKupdate');
    Route::get('/gtk/deleteAction{id}',[GTKController::class,'GTKdelete'])->name('GTKdelete');
    Route::post('/gtk/import/index',[GTKController::class,'GTKimportIndex'])->name('GTKimportIndex');
    Route::post('/gtk/import',[GTKController::class,'GTKimport'])->name('GTKimport');
    Route::post('/gtk/dataIndukGTKfoto',[GTKController::class,'GTKfoto'])->name('GTKfoto');
    Route::get('/gtk/cetak',[GTKController::class,'card'])->name('card');
    Route::post('/gtk/cetakmulti',[GTKController::class,'cardmulti'])->name('cardmulti');
    // route rfid
    Route::get('/rfid',[rfidController::class,'rfid'])->name('rfid');
    Route::get('/rfid/delete{id}',[rfidController::class,'rfidDelete'])->name('rfidDelete');

    Route::get('/device/lisensi',[lisensiController::class,'lisensiIndex'])->name('lisensiIndex');
    Route::get('/device/lisensiGet',[lisensiController::class,'lisensiIndexGet'])->name('lisensiIndexGet');
    Route::get('/device/checkLicense', [LisensiController::class, 'checkExpired']);

    //Route::post('/subcribe/payment', [PaymentController::class, 'createCharge']);

    Route::get('/gtk/employment_types',[GTKController::class,'employmenttypesIndex']);
    Route::post('/gtk/employment_typesAdd',[GTKController::class,'employmenttypesIndexAdd'])->name('employmenttypesIndexAdd');
    Route::post('/gtk/employment_typesUpdate',[GTKController::class,'employmenttypesIndexUpdate'])->name('employmenttypesIndexUpdate');
    Route::get('/gtk/employment_typesDelete{id}',[GTKController::class,'employmenttypesIndexDelete'])->name('employmenttypesIndexDelete');

    // route Pengguna
    Route::get('/user/administrator',[penggunaController::class,'userAdministratorIndex'])->name('userAdministratorIndex');
    Route::post('/user/administratorAdd',[penggunaController::class,'userAdministratorAdd'])->name('userAdministratorAdd');
    Route::get('/user/students',[penggunaController::class,'userStudentsIndex'])->name('userStudentsIndex');
    Route::get('/user/teacher',[penggunaController::class,'useremployeesIndex'])->name('useremployeesIndex');
    Route::get('/modules',[penggunaController::class,'usermodulesIndex']);
    Route::get('/user/permission/{id}',[penggunaController::class,'usermodulesPermission'])->name('usermodulesPermission');
    Route::post('/user/permission/change',[penggunaController::class,'usermodulesPermissionChange'])->name('usermodulesPermissionChange');
    Route::get('/user/user_privileges',[penggunaController::class,'user_privilegesIndex']);
    Route::post('/user/changePassword',[penggunaController::class,'changePassword'])->name('changePassword');
    Route::post('/user/changeRole',[penggunaController::class,'changeRole'])->name('changeRole');


    Route::get('/verifikasiuser',[verifikasiUserController::class,'verifikasiUser']);
    Route::get('/verifikasiuserUpdate{id}',[verifikasiUserController::class,'verifikasiUpdate'])->name('verifikasiUpdate');
    // leasson
    Route::get('/class/leasson',[leassonController::class,'index'])->name('leasson');
    Route::get('/class/leasson/view/{id}',[leassonController::class,'leassonView'])->name('leassonView');
    Route::post('/class/leasson/reference',[leassonController::class,'reference'])->name('reference');
    Route::post('/class/leasson/reference/edit',[leassonController::class,'referenceEdit'])->name('referenceEdit');
    Route::get('/class/leasson/reference/delete{id}',[leassonController::class,'referenceDelete'])->name('referenceDelete');
    Route::post('/class/leasson/add',[leassonController::class,'leassonAdd'])->name('leassonAdd');
    Route::post('/class/leasson/addManual',[leassonController::class,'leassonAddManual'])->name('leassonAddManual');
    Route::post('/class/leasson/update',[leassonController::class,'leassonUpate'])->name('leassonUpdate');
    Route::get('/class/leasson/delete{id}',[leassonController::class,'leassonDelete'])->name('leassonDelete');
    Route::get('/class/leasson/list/{id}',[leassonController::class,'list'])->name('list');
    Route::get('/class/leasson/getgtk',[leassonController::class,'getgtk'])->name('getgtk.leasson');

    Route::get('/class/leasson/reference',[leassonController::class,'leassonTime'])->name('leasson.reference');



    Route::post('/file-tugas', [FileTugasController::class, 'store'])->name('filetugas.store');
    Route::get('/file-tugas/{file_id}', [FileTugasController::class, 'destroy'])->name('filetugas.delete');
    Route::post('/file-tugas/verifikasi', [FileTugasController::class, 'verifikasi'])->name('filetugas.verifikasi');
    // Route::post('/class/leasson/time/add',[leassonController::class,'addleassonTime'])->name('leasson.addtime');
    // Route::post('/class/leasson/time/update',[leassonController::class,'updateleassonTime'])->name('leasson.updatetime');
    // Route::get('/class/leasson/time/delete/{id}',[leassonController::class,'deleteleassonTime'])->name('leasson.deletetime');

    Route::get('/class/leasson/hari',[setelanHariController::class,'index'])->name('leasson.index');
    Route::post('/class/leasson/hari/add',[setelanHariController::class,'add'])->name('leasson.add');
    Route::post('/class/leasson/hari/update',[setelanHariController::class,'update'])->name('leasson.update');
    Route::get('/class/leasson/hari/delete/{id}',[setelanHariController::class,'delete'])->name('leasson.delete');

    // Apps Config Controller
    Route::get('/setelan/aplikasi', [AppsConfigController::class, 'app'])->name('setelan.app');
    Route::get('/setelan/sistem', [AppsConfigController::class, 'sistem'])->name('setelan.sistem');
    Route::get('/setelan/card', [AppsConfigController::class, 'card'])->name('setelan.card');
    Route::get('/bg-back/reset/', [AppsConfigController::class, 'reset'])->name('setelan.reset');
    Route::get('/setelan/customize', [AppsConfigController::class, 'customize'])->name('setelan.customize');
    Route::post('/setelan/aplikasi/change', [AppsConfigController::class, 'appChange'])->name('setelan.appChange');
    Route::post('/setelan/schooltime', [AppsConfigController::class, 'schoolTime'])->name('setelan.schoolTime');
    Route::get('/kalender',[FullCalenderController::class,'kalender']);
    Route::get('/events', [EventController::class, 'index']);  // Fetch events
    Route::post('/events/create', [EventController::class, 'create']);  // Create new event
    Route::get('/events/{id}', [EventController::class, 'destroy']);

    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::post('/announcements/update', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::get('/announcements/delete{id}', [AnnouncementController::class, 'delete'])->name('announcements.delete');

    // class Room
    Route::get('/classroom', [ClassRoomController::class, 'index'])->name('classroom.index');
    Route::post('/classroom/add', [ClassRoomController::class, 'add'])->name('classroom.add');
    Route::post('/classroom/update', [ClassRoomController::class, 'update'])->name('classroom.update');
    Route::get('/classroom/archive/{id}', [ClassRoomController::class, 'archive'])->name('classroom.archive');
    Route::get('/classroom/detail/{id}', [ClassRoomController::class, 'detail'])->name('classroom.detail');
    Route::get('/classroom/recommend', [ClassRoomController::class, 'recommend'])->name('classroom.recommend');

    Route::post('/classroom/detail/adduser', [ClassRoomDetailController::class, 'adduser'])->name('classroom.adduser');
    Route::post('/classroom/detail/adduserClass', [ClassRoomDetailController::class, 'adduserClass'])->name('classroom.adduserClass');
    Route::get('/classroom/detail/deleteuserClass/{id}', [ClassRoomDetailController::class, 'deleteuserClass'])->name('classroom.deleteuserClass');
    Route::get('/classroom/detail/tugas/{task_id}/{id_kelas}', [ClassRoomDetailController::class, 'detailTugas'])->name('classroom.detailTugas');
    Route::get('/classroom/addwork/{id}', [ClassRoomDetailController::class, 'tugas'])->name('classroom.tugas');
    Route::post('/classroom/addwork/add', [ClassRoomDetailController::class, 'tambahTugas'])->name('classroom.tambahTugas');
    Route::get('/classroom/addwork/edit/{task_id}', [ClassRoomDetailController::class, 'editTugas'])->name('classroom.editTugas');
    Route::post('/classroom/addwork/edit/action', [ClassRoomDetailController::class, 'editTugasAction'])->name('classroom.editTugasAction');
    Route::get('/classroom/addwork/edit/filedelete/{id}', [ClassRoomDetailController::class, 'filedelete'])->name('classroom.filedelete');
    Route::post('/classroom/addwork/edit/linkdelete', [ClassRoomDetailController::class, 'linkdelete'])->name('classroom.linkdelete');
    Route::post('/classroom/addAnnouncement', [ClassRoomDetailController::class, 'addAnnouncement'])->name('classroom.addAnnouncement');
    Route::get('/classroom/addwork/delete/{task_id}', [ClassRoomDetailController::class, 'deleteTaskAction'])->name('classroom.deleteTaskAction');
    Route::post('/classroom/addwork/delete/quiz', [ClassRoomDetailController::class, 'deletequizAction'])->name('classroom.quizTaskAction');

    Route::get('/classroom/questions/{id_kelas}/{task_id}/list', [ClassRoomDetailController::class, 'quiz'])->name('classroom.quiz');
    Route::get('/classroom/questions/{id_kelas}/{task_id}/create', [ClassRoomDetailController::class, 'tambahQuiz'])->name('classroom.tambahQuiz');
    Route::get('/classroom/questions/{id_kelas}/{id}/{task_id}/update', [ClassRoomDetailController::class, 'editQuiz'])->name('classroom.editQuiz');

    Route::post('/classroom/question/add', [ClassRoomDetailController::class, 'quizAdd'])->name('classroom.quizAdd');
    Route::post('/classroom/question/update', [ClassRoomDetailController::class, 'quizUpdate'])->name('classroom.quizUpdate');
    Route::get('/classroom/question/delete/{id}', [ClassRoomDetailController::class, 'quizDelete'])->name('classroom.quizDelete');
    Route::get('/quiz/{id_kelas}/{task_id}', [ClassRoomDetailController::class, 'quizIndex'])->name('quiz');
    Route::post('/quiz/submit', [ClassRoomDetailController::class, 'quizSubmit'])->name('quiz.submit');
    Route::post('/quiz/finish', [ClassRoomDetailController::class, 'quizFinish'])->name('quiz.finish');

    Route::get('/download/{filename}', [ClassRoomDetailController::class, 'download'])->name('download');
    Route::post('/preview-excel', [ExcelPreviewController::class, 'previewExcel'])->name('preview.excel');
    Route::post('/save-preview-data', [ExcelPreviewController::class, 'savePreviewData'])->name('save.preview.data');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');

    Route::post('/getsemester',[RegionController::class,'getsemester'])->name('getsemester');
    Route::post('/getwalikelas',[RegionController::class,'getwalikelas'])->name('getwalikelas');
    Route::post('/getgtk',[RegionController::class,'getgtk'])->name('getgtk');
    Route::post('/getmapel',[RegionController::class,'getmapel'])->name('getmapel');
});
Route::post('/logout',[authController::class,'logout'])->name('logout');
// route Regency Administrasi
Route::post('/getkabupaten',[RegionController::class,'getkabupaten'])->name('getkabupaten');
Route::post('/getkecamatan',[RegionController::class,'getkecamatan'])->name('getkecamatan');
Route::post('/getdesa',[RegionController::class,'getdesa'])->name('getdesa');


Route::get('/fullcalender',[FullCalenderController::class,'index']);
Route::post('/fullcalenderAjax',[FullCalenderController::class,'ajax']);
Route::post('/addEventModal',[FullCalenderController::class,'addEventModal']);

// route export
Route::get('/export/users', [PDFController::class, 'generatePDFUserAll'])->name('export.users');
Route::get('/export/users/admin', [PDFController::class, 'generatePDFUserAdmin'])->name('export.userAdmin');
Route::get('/export/users/walikelas', [PDFController::class, 'generatePDFUserWalikelas'])->name('export.userWalikelas');
Route::get('/export/users/gtks', [PDFController::class, 'generatePDFUserGuru'])->name('export.userGuru');
Route::get('/export/users/students', [PDFController::class, 'generatePDFUserSiswa'])->name('export.userSiswa');

Route::get('/export/gtks', [PDFController::class, 'generatePDFGTKAll'])->name('export.gtks');
Route::get('/export/students', [PDFController::class, 'generatePDFSiswaAll'])->name('export.students');
Route::get('/export/RFIDstudents', [PDFController::class, 'generatePDFRFIDstudents'])->name('export.RFIDstudents');
Route::get('/export/RFIDteachers', [PDFController::class, 'generatePDFRFIDteachers'])->name('export.RFIDstudents');
Route::get('/export/jadwal/{id_kelas}', [PDFController::class, 'generateJadwal'])->name('export.jadwal');
Route::get('/export/score/{id}', [PDFController::class, 'generateScore'])->name('export.score');

Route::get('/report/absentrfid/student', [reportController::class, 'reportRFIDStudent'])->name('reportRFIDStudent');
Route::get('/report/absentrfid/teacher', [reportController::class, 'reportRFIDTeacher']);
Route::get('/report/absent/students', [reportController::class, 'reportAbsentStudent']);
Route::get('/report/absent/kelas', [PDFController::class, 'reportAbsentKelas'])->name('absentKelas');

Route::get('/qr/{code}', [barcodeController::class, 'generateQRCode'])->name('qr.generate');
Route::get('/card', [barcodeController::class, 'card'])->name('card');
Route::get('/class/time', [inOutTimeController::class, 'indexClass'])->name('index.class');
Route::post('/class/time/update', [inOutTimeController::class, 'classTimeUpdate'])->name('time.update');




