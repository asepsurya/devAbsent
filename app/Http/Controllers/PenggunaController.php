<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

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
    public function useremployeesIndex(request $request){
        if ($request->ajax()) {
            return DataTables::of(user::where(['role'=>'guru'])->orderBy('id', 'DESC'))->addIndexColumn()->toJson();
        }

        return view('pengguna.GTK',[
            'title' => 'Guru dan Tenaga Kependidikan',
            'gtks'=>User::where('role','guru')->get(['id','role'])
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
