<?php

namespace App\Http\Controllers;
use App\Models\Province;
use App\Models\student;
use App\Models\gtk;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
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
         $validatedData['status'] = '1';

         User::create($validatedData);
         $cekid = User::where('nomor',$request->nis)->get();

            foreach($cekid as $key){
                $getid = $key->id;
                DB::table('model_has_roles')->insert([
                    'role_id' => '3',
                    'model_type'=>'App\Models\User',
                    'model_id'=>$getid
                ]);
            }
         toastr()->success('Pendaftaran Berhasil');
         return redirect()->route('registerinfo');
    }
    public function registerinfo(request $request){
        return view('authentication.info',[
            'title'=>'Terimakasih'
        ]);
    }
    public function registerInputTeacher(request $request){
        $validator = $request->validate([
            'nik' => 'required|min:10|unique:gtks',
            'nip' => 'min:18|unique:gtks',
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
            'telp'=>'required',
        ]);

        $validator['status'] = '1';
        $validator['tanggal_masuk'] = '';
        $validator['id_rfid']= '';
        $validator['id_jenis_gtk']='3';

        gtk::create($validator);
        $validatedData = $request->validate([
            'nama'=>'required',
            'email'=>'required|email|unique:Users',
            'password'=>'required|same:Cpassword|min:6',

        ]);
         // // enkripsi password
         $validatedData['password'] = Hash::make($validatedData['password'] );
         $validatedData['nama'] = $request->nama;
         $validatedData['nomor'] = $request->nik;
         $validatedData['role'] = '3';
         $validatedData['status'] = '1';

         User::create($validatedData);
         $cekid = User::where('nomor',$request->nik)->get();
        foreach($cekid as $key){
            $getid = $key->id;
            foreach($cekid as $key){
                $getid = $key->id;
                DB::table('model_has_roles')->insert([
                    'role_id' => '2',
                    'model_type'=>'App\Models\User',
                    'model_id'=>$getid
                ]);
            }
        }
         toastr()->success('Pendaftaran Berhasil');
         return redirect()->route('registerinfo');

    }
    // login Action
    public function loginAction(request $request){

        $cek = $request->validate([
            'email'=>'required',
            'password'=>'required|min:6'
        ]);
        $cek['status'] = '2';
        if(Auth::attempt($cek)){
            $request->session()->regenerate();

            if(Auth()->user()->role === 'admin'){
                toastr()->success('Login Berhasil');
                return redirect()-> intended(route('dashboard.admin'));

            }elseif(Auth()->user()->role === 'walikelas'){
                toastr()->success('Login Berhasil');
                return redirect()-> intended(route('dashboard.walikelas'));

            }elseif(Auth()->user()->role === 'guru'){
                toastr()->success('Login Berhasil');
                return redirect()-> intended(route('dashboard.teacher'));

            }elseif(Auth()->user()->role === 'siswa'){
                toastr()->success('Login Berhasil');
                return redirect()-> intended(route('dashboard.student'));
            }
        }else{
            //jika login error
            toastr()->error('Login Gagal!! Periksa Kembali Data Anda');
            return back()->with('loginError','Login Gagal!! Periksa Kembali Data Anda');

        }
    }

    public function profileIndex($id){
        return view('setelan.profile',[
            'title'=>'Profil Saya',
            'user'=>User::where('nomor',$id)->get(),
            'provinsi'=>Province::all()
        ]);
    }
    public function profileUpdate(request $request){
        if(auth()->user()->role == "siswa"){
            student::where('nis',$request->id)->update([
                "alamat" => $request->alamat,
                "id_provinsi" => $request->id_provinsi,
                "id_kota" => $request->id_kota,
                "id_kecamatan" => $request->id_kecamatan,
                "id_desa" => $request->id_desa
            ]);
        }else{
            gtk::where('nik',$request->id)->update([
                "alamat" => $request->alamat,
                "id_provinsi" => $request->id_provinsi,
                "id_kota" => $request->id_kota,
                "id_kecamatan" => $request->id_kecamatan,
                "id_desa" => $request->id_desa
            ]);
        }
        toastr()->success('Data berhasil diupdate');
        return redirect()->back();
    }
    public function imageProfile(request $request){
        if(auth()->user()->role == "walikelas" || auth()->user()->role == "guru" ){
            $validasiGambar = $request->validate([
                'gambar'=>'image|file',
             ]);
            if($request->file('gambar')){
                //gambar dibah maka gambar di storage di hapus
                if($request->oldImage){
                    Storage::delete($request->oldImage);
                }
                $validasiGambar['gambar'] = $request->file('gambar')->store('FotoProfile');
             }
             gtk::where('nik',$request->id)->update($validasiGambar);
             toastr()->success('Data berhasil diupdate');
        }else{
            $validasiGambar = $request->validate([
                'foto'=>'image|file',
             ]);
            if($request->file('foto')){
                //gambar dibah maka gambar di storage di hapus
                if($request->oldImage){
                    Storage::delete($request->oldImage);
                }
                $validasiGambar['foto'] = $request->file('foto')->store('FotoProfile');
             }
             student::where('nis',$request->id)->update($validasiGambar);
             toastr()->success('Data berhasil diupdate');
        }
        return redirect()->back();
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
        return 'halaman create';
    }
}
