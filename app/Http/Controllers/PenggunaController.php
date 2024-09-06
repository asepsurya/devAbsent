<?php

namespace App\Http\Controllers;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    Public function userAdministratorIndex(){
        return view('pengguna.administrator',[
            'title' => 'Pengguna Administrator'
        ]);
    }
    public function userStudentsIndex(){
        return view('pengguna.pesertadidik',[
            'title' => 'Peserta Didik',
            'students'=>User::where('role','siswa')->with('student')->get()
        ]);
    }
    public function useremployeesIndex(){
        return view('pengguna.GTK',[
            'title' => 'Guru dan Tenaga Kependidikan'
        ]);
    }
    public function usermodulesIndex(){
        $roles = DB::table('roles')->get();
        return view('pengguna.modul',[
            'title' => 'Daftar Modul',
            'roles' => $roles
        ]);
    }
    public function user_privilegesIndex(){
        return view('pengguna.hakAkses',[
            'title' => 'Hak Akses'
        ]);
    }
    public function userAdministratorAdd(request $request){
        toastr()->error('An error has occurred please try again later.');
        return redirect()->back();
    }
}
