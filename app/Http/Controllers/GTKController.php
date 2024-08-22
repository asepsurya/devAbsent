<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\JenisGTK;
use App\Models\gtk;
use App\Models\User;
use App\Models\rfid;
use App\Models\grupMapel;
use App\Models\media;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
class GTKController extends Controller
{
    public function GTKall(){
        return view('GTK.gtk',[
            'title'=>'Guru dan Tenaga Kependidikan',
            'provinsi'=>Province::all(),
            'gtk'=>gtk::orderBy('id', 'DESC')->with(['Usergtk'])->paginate(10),

        ]);
    }
    public function employmenttypesIndex(){
        return view('GTK.jenis',[
            'title'=>'Jenis Guru dan Tenaga Kependidikan',
            'jnsGTK'=>JenisGTK::all()
        ]);
    }
    public function employmenttypesIndexAdd(request $request){
        JenisGTK::create([
            'nama'=>$request->nama
        ]);
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }

    public function employmenttypesIndexUpdate(request $request){
        JenisGTK::where('id',$request->id)->update(['nama'=>$request->nama]);
        toastr()->success('Data Berhasil diubah');
        return redirect()->back();
    }

    public function employmenttypesIndexDelete($id){
        JenisGTK::where('id',$id)->delete();
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back();
    }

    // GTK
    public function GTKaddIndex(){
       return view('GTK.gtkAction.addGtk',[
        'title'=>'Tambah Guru dan Tenaga Kependidikan Baru',
        'provinsi'=>Province::all(),
        'jnsGTK'=>JenisGTK::all(),
       ]);
    }


    public function GTKadd(request $request){
       $validasi = Validator::make($request->all(),[
        'nik'=>'required|unique:gtks',
        'email'=>'required|unique:users',
        // 'id_provinsi'=>'required',
        // 'id_kota'=>'required',
        // 'id_kecamatan'=>'required',
        // 'id_desa'=>'required',
       ]);
        if ($validasi->fails()){
                toastr()->error('Data Gagal Disimpan');
                return redirect()->back()->with('error_code', 5)->withErrors($validasi)->withInput();
        }else{
            gtk::create([
                'nik' => $request->nik,
                'tempat_lahir' => $request->tempat_lahir,
                'gender' => $request->gender,
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'telp' => $request->telp,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'id_provinsi' => $request->id_provinsi,
                'id_kota' => $request->id_kota,
                'id_kecamatan' => $request->id_kecamatan,
                'id_desa' => $request->id_desa,
                'id_jenis_gtk' => $request->jns_gtk,
                'status' => $request->status,
                'tanggal_masuk' =>'',
                'id_rfid' =>'',
                'gambar'=> '',
            ]);
            User::create([
                'nomor'=>$request->nik,
                'nama'=>$request->nama,
                'email'=>$request->email,
                'password'=>Hash::make($request->nik),
                'role'=>'3',
                'status'=>'2'
            ]);
            toastr()->success('Data Berhasil disimpan');
            return redirect()->back();
        }
    }

    public function GTKupdateIndex($id){
        return view('GTK.gtkAction.editGtk',[
            'title'=>'Edit Guru dan Tenaga Kependidikan',
            'provinsi'=>Province::all(),
            'jnsGTK'=>JenisGTK::all(),
            'gtk'=>gtk::where('id',$id)->with(['Usergtk','kota','kecamatan','desa','MapelgtkList','Mapelgtklist.mata_pelajaran','Mapelgtklist.kelas','Mapelgtklist.kelas.jurusanKelas'])->get(),
            'rfid'=>rfid::all()
        ]);
    }

    public function GTKupdate(request $request){

         $validasiGambar = $request->validate([
            'gambar'=>'image|file',
            'nik' => 'required',
            'tempat_lahir' => 'required',
            'gender' => 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'agama' => 'required',
            'telp' =>'required',
            'alamat' => 'required',
            'telp' => 'required',
            'id_provinsi' => '',
            'id_kota' => '',
            'id_kecamatan' => '',
            'id_desa' => '',
            'id_jenis_gtk' => '',
            'status' => '',
            'tanggal_masuk' =>'',
            'id_rfid' =>'',
        ]);

        if($request->file('gambar')){
            //gambar dibah maka gambar di storage di hapus
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validasiGambar['gambar'] = $request->file('gambar')->store('FotoProfile');
        }
        gtk::where('nik',$request->id)->update($validasiGambar);
        User::where('nomor',$request->id)->update([
            'nomor'=>$request->nik,
            'nama'=>$request->nama,
            'email'=>$request->email,
            'password'=>Hash::make($request->nik),
            'role'=>'3',
            'status'=>'2'
        ]);
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();

        }

        public function GTKdelete($id){
            gtk::where('nik',$id)->delete();
            User::where('nomor',$id)->delete();
            toastr()->success('Data Berhasil dihapus');
            return redirect()->back();
        }
}
