<?php

namespace App\Http\Controllers;
use App\Models\Province;
use App\Models\student;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class authController extends Controller
{
    public function loginIndex(){
        return view('authentication.login',[
            'title'=>'Login App'
        ]);
    }
    public function registerIndex(){
        return view('authentication.register',[
            'title'=>'Login App',
            'provinsi'=>Province::all()
        ]);
    }
    public function registerInput(request $request){
        $validator = $request->validate([
            'nis' => 'required|min:10|unique:students',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'gender' => 'required',
            'tanggal_lahir' => 'required',
            'agama' =>'required',
            'alamat' => 'required',
            'id_provinsi' =>'required',
            'id_kota' =>'required',
            'id_kecamatan' =>'required',
            'id_desa' => 'required',
            'email'=>'required|email|unique:Users',
            'password'=>'required|same:Cpassword|min:6',
        ]);
       
        $validator['status'] = '1';
        $validator['tanggal_masuk'] = '';
        $validator['id_rfid']= '';
        $validator ['id_kelas' ]= '';
        $validator['id_rombel']='';
        
        student::create($validator);
        
        $validatedData = $request->validate([
            'nama'=>'required',
            'email'=>'required|email|unique:Users',
            'password'=>'required|same:Cpassword|min:6',
       
        ]);
         // // enkripsi password
         $validatedData['password'] = Hash::make($validatedData['password'] );
         $validatedData['nama'] = $request->nama;
         $validatedData['nomor'] = $request->nis;
         $validatedData['role'] = '4';
         
         User::create($validatedData);
         return redirect('/login')->with('Berhasil','Hallo Selamat Datang'.$request->nama);
    }
    // login Action
    public function loginAction(request $request){
        $cek = $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        
        if(Auth::attempt($cek)){
            $request->session()->regenerate();
            toastr()->success('Login Berhasil');
            return redirect()-> intended('/dashboard');
        }
        //jika login error
        toastr()->error('Login Gagal!! Periksa Kembali Data Anda');
        return back()->with('loginError','Login Gagal!! Periksa Kembali Data Anda');
    }

    // logout action
    Public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function role(request $request){
        return view('sample');
        // if($request->user()->hasRole('siswa')){
        //     return 'role';
        // }
        // abort(403);
    }
   
    public function create(request $request){
        return ' halama create';
    }
}
