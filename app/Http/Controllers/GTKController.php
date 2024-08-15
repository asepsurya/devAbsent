<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\JenisGTK;
use App\Models\gtk;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class GTKController extends Controller
{
    public function GTKall(){
        return view('GTK.gtk',[
            'title'=>'Guru dan Tenaga Kependidikan',
            'provinsi'=>Province::all(),
            'jnsGTK'=>JenisGTK::all(),
            'gtk'=>gtk::orderBy('id', 'DESC')->get(),
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
    public function GTKadd(request $request){
        gtk::create([
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'gender' => $request->gender,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'id_provinsi' => $request->id_provinsi,
            'id_kota' => $request->id_kota,
            'id_kecamatan' => $request->id_kecamatan,
            'id_desa' => $request->id_desa,
            'id_jns_gtk' => $request->jns_gtk,
            'status' => $request->status,
            'tanggal_masuk' =>'',
            'id_rfid' =>'',  
        ]);
        User::create([
            'nomor'=>$request->nik,
            'nama'=>$request->nama,
            'email'=>$request->email,
            'password'=>Hash::make($request->nik),
            'role'=>'3'
        ]);
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back();
   
    }
}
