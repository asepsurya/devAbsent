<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PenggunaController extends Controller
{
    Public function userAdministratorIndex(){
        return view('pengguna.administrator',[
            'title' => 'Administrator',
            'userAdmin'=>User::where('role','admin')->paginate(15)
        ]);
    }
    public function userStudentsIndex(request $request){
        if ($request->ajax()) {
            return DataTables::of(User::where(['role'=>'siswa'])->orderBy('id', 'DESC'))->addIndexColumn()->toJson();
        }
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
            'title' => 'Modul',
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
    public function usermodulesPermission($id){
        $cek = DB::table('role_has_permissions')->where([
            'role_id' => $id
        ])->get();
        return view('pengguna.permission',[
            'title'=>'Roles Permission',
            'modules'=>Permission::whereNotIn('name', ['create', 'delete','update','read'])->get(),
            'cekmodul'=>$cek
        ],compact('id'));
    }
    public function usermodulesPermissionChange(request $request){
        $role = $request->role;
        DB::table('role_has_permissions')->where('role_id', $role)->delete();
        foreach($request->permission as $data => $key){
            DB::table('role_has_permissions')->insert([
                'permission_id'=> $data,
                'role_id' => $role
            ]);
        }
       Artisan::call('cache:clear');
       return redirect()->back();
    }

    public function changePassword(request $request){
        $validasi = $request->validate([
            'password'=>'required|same:cpassword|min:6'
        ]);
        $validasi['password'] = Hash::make($validasi['password']);
        User::where('id',$request->id)->update($validasi);
        toastr()->success('Password berhasi diubah');
        return redirect()->back();
    }
}
