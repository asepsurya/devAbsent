<?php

namespace App\Http\Controllers;

use App\Models\rfid;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\absent;
use App\Models\rombel;
use App\Models\Jurusan;
use App\Models\student;
use App\Models\Province;
use Illuminate\View\View;
use App\Models\absentMapel;
use Illuminate\Http\Request;
use App\Models\absentsHistory;
use App\Models\TahunPelajaran;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use App\Models\model_has_roles;
use App\Imports\UserStudentImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MyRolesStudentImport;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
    public function dataIndukStudentCard(){
        $data = student::where('id',request('data'))->get();
        foreach($data as $item){ $nama = $item->nama;$nis=$item->nis; }
       return view('akdemik.datainduk.card.studentCard',[
            'data'=>$data
       ],compact('nama','nis'));
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
        ],compact('id'));
    }

    public function dataIndukStudentfoto(request $request){
    // Validate inputs
    $request->validate([
        'id' => 'required|exists:students,id',
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
        Student::where('id', $request->id)->update(['foto' => $fileName]);

        toastr()->success('Profile photo updated successfully.');
        return redirect()->back();

    } catch (\Exception $e) {
        toastr()->error('An error occurred: ' . $e->getMessage());
        return redirect()->back();
    }

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
        // Method ubah rfid ketika  RFID Berubah
        $cekrfid = absent::where('id_rfid',$request->old_rfid)->get();
        if($cekrfid->count()){
            if($cekrfid->where('id_rfid',$request->old_rfid) !== $request->id_rfid ){
                rfid::where('id_rfid',$request->old_rfid)->update(['status'=>'1']);
                absent::where('id_rfid',$request->old_rfid)->update(['id_rfid'=>$request->id_rfid]);
                absentsHistory::where('uid',$request->old_rfid)->update(['uid'=>$request->id_rfid]);
            }
        }
        // Method jika NIS di rubah
        $cekNIS = student::where('nis',$request->nis)->get();
        if($cekNIS->count()){
            if($cekNIS->where('nis',$request->old_nis) !== $request->nis ){
                rombel::where('nis',$request->old_nis)->update(['nis'=> $request->nis]);
                user::where('nomor',$request->old_nis)->update(['nomor'=>$request->nis,'email'=>$request->nis,'password'=>Hash::make($request->nis)]);
                absentMapel::where('nis',$request->old_nis)->update(['nis'=>$request->nis]);
            }
        }

        $cek = rombel::where('nis',$request->nis)->get();
        if($cek->count()){
            rombel::where('nis',$request->nis)->update(['id_rfid'=>$request->id_rfid]);
        }
        toastr()->success('Data Berhasil disimpan');
        return redirect()->route('studentEditIndex', $request->id);

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

        TahunPelajaran::where('status', 1)->update(['status' => 2]);
        $status = ($request->status == 1) ? 1 : 2;

        TahunPelajaran::create([
            'tahun_pelajaran'=>$request->tahun_pelajaran,
            'semester'=>$request->semester,
            'status'=>$status,
        ]);
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }

    public function dataIndukTahunajarUpdate(request $request){
        TahunPelajaran::where('status', 1)->update(['status' => 2]);
        $status = ($request->status == 1) ? 1 : 2;

        TahunPelajaran::where('id',$request->id)->update([
            'tahun_pelajaran'=>$request->tahun_pelajaran,
            'semester'=>$request->semester,
            'status'=>$status,
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
