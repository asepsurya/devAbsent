<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

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
            'students'=>User::where('role','siswa')->with('student')->paginate(15)
        ]);
    }
    public function useremployeesIndex(){
        return view('pengguna.GTK',[
            'title' => 'Guru dan Tenaga Kependidikan',
            'gtks'=>User::where('role','guru')->with('gtk')->paginate(15)
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
    public function usermodulesPermission(){

        return view('pengguna.permission',[
            'title'=>'Roles Permission',
            'modules'=>Permission::all()
        ]);
    }
}
