<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;
use App\Models\Province;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\rombel;
use App\Models\Mapel;
use App\Models\User;
use App\Models\rfid;
use App\Models\model_has_roles;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\UserStudentImport;
use App\Imports\MyRolesStudentImport;
use App\Imports\StudentsImport;
use App\Exports\StudentsExport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TahunPelajaran;
use Illuminate\View\View;

class DataIndukController extends Controller
{
    public function dataIndukStudent(request $request) {
        if ($request->ajax()) {
            $model = student::orderBy('id', 'DESC')->with(['rombelstudent','getKelas']);
            return DataTables::eloquent($model)
            ->addColumn('rombel', function (student $item) {
                if($item->getKelas == NULL){
                    return 'Belum Disetel';
                }else{
                    $a = $item->getKelas->nama_kelas;
                    $b = $item->getKelas->jurusanKelas->nama_jurusan;
                    $c =  $item->getKelas->sub_kelas;
                    return $a.' '.$b.' '.$c;
                }
           })->addIndexColumn()->toJson();

        }
        return view('akdemik.datainduk.student',[
            'title'=>'Peserta Didik',
            'students'=>student::orderBy('nama', 'ASC')->get(['id','nis']),
            'provinsi'=>Province::all()
        ]);
    }
    public function dataIndukJurusan(){
        return view('akdemik.datainduk.jurusan',[
            'title'=>'Jurusan',
            'jurusans'=>Jurusan::all(),

        ]);
    }
    public function dataIndukkelas(){
        return view('akdemik.datainduk.kelas',[
            'title'=>'Kelas',
            'kelas'=>Kelas::orderBy('id', 'ASC')->with('jurusanKelas')->get(),
            'jurusans'=>Jurusan::where('status','1')->get()
        ]);
    }
    public function dataIndukMapel(){
        return view('akdemik.datainduk.mataPelajaran',[
            'title'=>'Mata Pelajaran',
            'mapel'=>Mapel::orderBy('id', 'ASC')->paginate(20)
        ]);
    }

    public function dataIndukMapelTahunajar(){
        return view('akdemik.datainduk.tahunajar',[
            'title'=>'Tahun Pelajaran',
            'tahunAjar'=>TahunPelajaran::all()
        ]);
    }
    public function dataIndukStudentAddIndex(){
        return view('akdemik.datainduk.students.addStudent',[
            'title'=>'Tambah Peserta Didik Baru',
            'provinsi'=>Province::all()
        ]);
    }
    public function dataIndukStudentAdd(request $request){
        $validator = $request->validate([
            'nis' => 'required|min:9|unique:students',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'gender' => 'required',
            'tanggal_lahir' => 'required',
            'agama' =>'required',
            'alamat' => '',
            'id_provinsi' =>'',
            'id_kota' =>'',
            'id_kecamatan' =>'',
            'id_desa' => '',

        ]);
        $validator['status'] = '1';
        $validator['tanggal_masuk'] = '';
        $validator['id_rfid']= '';
        $validator ['id_kelas' ]= '';
        $validator['id_rombel']='';
        $validator['foto']='';

        student::create($validator);

        User::create([
            'nomor'=>$request->nis,
            'nama'=>$request->nama,
            'email'=>$request->nis . '@saktiproject.my.id',
            'password'=>Hash::make($request->nis),
            'role'=>'4',
            'status'=>'2'
        ]);

        // insert to tabel model_has_roles untuk Role Hak Akses
        $cekid = User::where('nomor',$request->nis)->get();
        foreach($cekid as $key){
            $getid = $key->id;
            DB::table('model_has_roles')->insert([
                'role_id' => '3',
                'model_type'=>'App\Models\User',
                'model_id'=>$getid
            ]);
        }
        // role walikelas:1 guru:2 siswa:3 admin:4
        toastr()->success('Data Berhasil diSimpan');
        return redirect()->route('dataIndukStudent');

    }
    public function studentEditIndex($id){
        return view('akdemik.datainduk.students.editStudent',[
            'title'=>'Edit Data Peserta Didik',
            'students'=>student::where('id',$id)->get(),
            'provinsi'=>Province::all(),
            'rfid'=>rfid::where('status','1')->get(),
        ]);
    }
    public function dataIndukStudentEdit(request $request){
        $validator = $request->validate([
            'nis' => '',
            'nama' => '',
            'tempat_lahir' => '',
            'gender' => '',
            'tanggal_lahir' => '',
            'agama' =>'',
            'alamat' => '',
            'id_provinsi' =>'',
            'id_kota' =>'',
            'id_kecamatan' =>'',
            'id_desa' => '',
            'status' => '',
            'tanggal_masuk' => '',
            'id_rfid' => '',
            'id_kelas' => '',
            'id_rombel' => '',
            'foto' => ''
        ]);

        if($request->file('foto')){
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validator['foto'] = $request->file('foto')->store('FotoProfile');
        }
        student::where('id',$request->id)->update($validator);
        rfid::where('id_rfid',$request->id_rfid)->update(['status'=>'2']);
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();

    }
    public function studentDelete ($id){
        // cek table siswa untuk menghapus rfid
        $cekstudentrfid =  student::where('nis',$id)->get();
        foreach($cekstudentrfid as $key){
            rfid::where('id_rfid',$key->id_rfid)->update(['status'=>'1']);
        }
        // hapus data tabel student
        student::where('nis',$id)->delete();
        // hapus data rombel student
        rombel::where('nis', $id)->delete();

        // Hapus data Table model_has_roles
        $cekid = User::where('nomor',$id)->get();
        foreach($cekid as $key){
            $getid = $key->id;
            DB::table('model_has_roles')->where('model_id','=', $getid)->delete();
        }
        // Hapus Tabel User
        User::where('nomor',$id)->delete();

        toastr()->success('Data Berhasil dihapus');
        return redirect()->back();
    }
    public function studentIndex(){
        $file = asset('file_siswa/340817178Data Siswa Sample.xlsx');
       $data =  Excel::load($file, function($reader) {
            $results = $reader->get();
            $results = $reader->all();
         })->get();

        return view('akdemik.datainduk.students.import',[
            'title'=>'Import Data Peserta Didik',
            'a'=> $data
        ]);
    }

    public function studentImport(request $request){
        try {

        } catch (\Throwable $th) {
            return redirect()->back();
        }
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        // menangkap file excel
        $file = $request->file('file');
        // membuat nama file unik
        $nama_file = rand().$file->getClientOriginalName();
        // upload ke folder file_siswa di dalam folder public
        $file->move('file_siswa',$nama_file);

        // import data
        Excel::import(new UserStudentImport, public_path('/file_siswa/'.$nama_file));
        Excel::import(new StudentsImport, public_path('/file_siswa/'.$nama_file));
        Excel::import(new MyRolesStudentImport, public_path('/file_siswa/'.$nama_file));

        // notifikasi dengan session
        toastr()->success('Data Berhasil diImport');
        // alihkan halaman kembali
        return redirect()->back();

    }
    public function studentEksportExcel(){
        $date = date('d-m-Y');
        return Excel::download(new StudentsExport, 'Data Siswa-'.$date.'.xlsx');
    }

    public function dataIndukJurusanAdd(request $request){
        Jurusan::create([
            'nama_jurusan'=>$request->nama,
            'kurikulum'=>$request->kurikulum,
            'status'=>$request->status,

        ]);
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }

    public function dataIndukJurusanUpdate(request $request){
        Jurusan::where('id',$request->id)->update([
            'nama_jurusan'=>$request->nama,
            'kurikulum'=>$request->kurikulum,
            'status'=>$request->status,
        ]);
        toastr()->success('Data Berhasil diubah');
        return redirect()->back();
    }
    public function dataIndukJurusanDelete($id){
        Jurusan::where('id',$id)->delete();
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back();
    }
    // kelas
    public function dataIndukkelasAdd(request $request){
        Kelas::create([
            'nama_kelas'=>$request->nama,
            'id_jurusan'=>$request->id_jurusan,
            'sub_kelas'=>$request->sub_kelas,
            'kapasitas'=>$request->kapasitas,
            'status'=>$request->status,
        ]);
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }
    public function dataIndukkelasEdit(request $request){
        Kelas::where('id',$request->id)->update([
            'nama_kelas'=>$request->nama,
            'id_jurusan'=>$request->id_jurusan,
            'sub_kelas'=>$request->sub_kelas,
            'kapasitas'=>$request->kapasitas,
            'status'=>$request->status,
        ]);
        toastr()->success('Data Berhasil diubah');
        return redirect()->back();
    }

    public function dataIndukkelasDelete($id){
        kelas::where('id',$id)->delete();
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back();
    }
    // Mata Pelajaran
    public function dataIndukMapelAdd(request $request){
        Mapel::create([
            'nama'=>$request->nama,
            'jml_jam'=>$request->jml_jam,
            'type'=>$request->type,
            'status'=>$request->status,
        ]);
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }
    public function dataIndukMapelUpdate(request $request){
        Mapel::where('id',$request->id)->update([
            'nama'=>$request->nama,
            'jml_jam'=>$request->jml_jam,
            'type'=>$request->type,
            'status'=>$request->status,
        ]);
        toastr()->success('Data Berhasil diubah');
        return redirect()->back();
    }
    public function dataIndukMapelDelete($id){
        Mapel::where('id',$id)->delete();
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back();
    }
    // Tahun Pelajaran
    public function dataIndukTahunajarAdd(request $request){
        TahunPelajaran::create([
            'tahun_pelajaran'=>$request->tahun_pelajaran,
            'semester'=>$request->semester,
            'status'=>$request->status,
        ]);
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }

    public function dataIndukTahunajarUpdate(request $request){
        TahunPelajaran::where('id',$request->id)->update([
            'tahun_pelajaran'=>$request->tahun_pelajaran,
            'semester'=>$request->semester,
            'status'=>$request->status,
        ]);
        toastr()->success('Data Berhasil diubah');
        return redirect()->back();
    }
    public function dataIndukTahunajarDelete($id){
        TahunPelajaran::where('id',$id)->delete();
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back();
    }



// ini adalah API untuk Index Jurusan
    public function APIJurusan(){
        $data = TahunPelajaran::orderBy('id','ASC')->get();
        return response()->json([
            'status'=>true,
            'message'=>'Data ditemukan',
            'data'=>$data
        ],200);
    }
}
