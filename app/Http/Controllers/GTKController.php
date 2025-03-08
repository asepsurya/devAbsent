<?php

namespace App\Http\Controllers;

use App\Models\gtk;
use App\Models\rfid;
use App\Models\User;
use App\Models\media;
use App\Models\JenisGTK;
use App\Models\Province;
use App\Models\grupMapel;
use App\Imports\GtkImport;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use App\Imports\MyRolesGTKImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class GTKController extends Controller
{
    public function GTKall(request $request){
        if ($request->ajax()) {
            return DataTables::of(gtk::orderBy('nama', 'ASC'))->addIndexColumn()->toJson();
        }
        return view('GTK.gtk',[
            'title'=>'Guru dan Tenaga Kependidikan',
            'provinsi'=>Province::all(),
            'gtk'=>gtk::orderBy('nama', 'ASC')->get(['id','nik']),

        ]);
    }
    public function card(){
        $data = gtk::where('id',request('data'))->with('JenisGTK')->get();
        foreach($data as $item){ $nama = $item->nama;$nik=$item->nik; }
        return view('akdemik.datainduk.card.gtkCard',[
            'title'=>'Kartu Nama ',
            'data'=>$data
        ],compact('nama','nik'));
    }

    public function cardmulti(request $request){
        $data = gtk::whereIn('id',$request->id)->get();

        return view('GTK.gtkAction.printCardGTK',[
            'data'=>$data
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

            // insert to tabel model_has_roles untuk Role Hak Akses
            $cekid = User::where('nomor',$request->nik)->get();
            foreach($cekid as $key){
                $getid = $key->id;
                DB::table('model_has_roles')->insert([
                    'role_id' => '2',
                    'model_type'=>'App\Models\User',
                    'model_id'=>$getid
                ]);
            }

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

        public function GTKimportIndex(){
            return view('GTK.import.import',[
                'title'=>' Daftar Peserta Didik '
            ]);
        }

        public function GTKimport(request $request){
            $request->validate([
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);
            // menangkap file excel
            $file = $request->file('file');
            // membuat nama file unik
            $nama_file = rand().$file->getClientOriginalName();
                     // upload ke folder file_siswa di dalam folder public
            $file->move('file_gtk',$nama_file);
                 // import data
            Excel::import(new UserImport, public_path('/file_gtk/'.$nama_file));
            Excel::import(new GtkImport, public_path('/file_gtk/'.$nama_file));
            Excel::import(new MyRolesGTKImport, public_path('/file_gtk/'.$nama_file));
            // notifikasi dengan session
            toastr()->success('Data Berhasil diImport');
            // alihkan halaman kembali
            return redirect()->back();

        }

        public function GTKdelete($id){
            $cekid = User::where('nomor',$id)->get();
            foreach($cekid as $key){
                $getid = $key->id;
                DB::table('model_has_roles')->where('model_id','=', $getid)->delete();
             }
            gtk::where('nik',$id)->delete();
            User::where('nomor',$id)->delete();
            toastr()->success('Data Berhasil dihapus');
            return redirect()->back();
        }

    public function GTKfoto(request $request){
        // Validate inputs
        $request->validate([
            'id' => 'required|exists:gtks,id',
            'croppedFoto' => 'required|string', // Base64 string
        ]);

    try {
        // Extract the Base64 string
        $base64Image = $request->input('croppedFoto');

        // Decode and process the image
        $imageParts = explode(';base64,', $base64Image);
        $imageType = explode('image/', $imageParts[0])[1]; // Get extension (e.g., jpeg, png)
        $imageBase64 = base64_decode($imageParts[1]);

        // Generate unique file name
        $fileName = 'FotoProfile/' . uniqid() . '.' . $imageType;

        // Save to storage
        Storage::put($fileName, $imageBase64);

        // Delete old image if it exists
        if ($request->oldImage) {
            Storage::delete($request->oldImage); // Deletes from `storage/app`
        }

        // Update database with new image path
        gtk::where('id', $request->id)->update(['gambar' => $fileName]);

        toastr()->success('Profile photo updated successfully.');
        return redirect()->back();

    } catch (\Exception $e) {
        toastr()->error('An error occurred: ' . $e->getMessage());
        return redirect()->back();
    }
        }
}
