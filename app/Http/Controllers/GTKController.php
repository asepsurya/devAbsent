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
use Yajra\DataTables\Facades\DataTables;
use App\Imports\GtkImport;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
class GTKController extends Controller
{
    public function GTKall(request $request){
        if ($request->ajax()) {
            return DataTables::of(gtk::orderBy('id', 'DESC'))->addIndexColumn()->toJson();
        }
        return view('GTK.gtk',[
            'title'=>'Guru dan Tenaga Kependidikan',
            'provinsi'=>Province::all(),
            'gtk'=>gtk::orderBy('id', 'DESC')->get(['id','nik']),

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
                'nip' => $request->nip,
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
            'rfid'=>rfid::where('status','1')->get()
        ]);
    }

    public function GTKupdate(request $request){

         $validasiGambar = $request->validate([
            'gambar'=>'image|file',
            'nik' => 'required',
            'nip' => '',
            'tempat_lahir' => 'required',
            'gender' => 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'agama' => 'required',
            'telp' =>'required',
            'alamat' => '',
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
        rfid::where('id_rfid',$request->id_rfid)->update(['status'=>'2']);
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();

        }
        public function GTKimport(request $request){
            $request->validate([
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);
            // menangkap file excel
            $file = $request->file('file');
            // membuat nama file unik
            $nama_file = rand().$file->getClientOriginalName();

            try {
                     // upload ke folder file_siswa di dalam folder public
            $file->move('file_gtk',$nama_file);
                 // import data
            Excel::import(new GtkImport, public_path('/file_gtk/'.$nama_file));
            Excel::import(new UserImport, public_path('/file_gtk/'.$nama_file));
            // notifikasi dengan session
            toastr()->success('Data Berhasil diImport');
            // alihkan halaman kembali
            return redirect()->back();
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                return redirect()->back()->compact('e');
            }

        }

        public function GTKdelete($id){
            gtk::where('nik',$id)->delete();
            User::where('nomor',$id)->delete();
            toastr()->success('Data Berhasil dihapus');
            return redirect()->back();
        }
}
