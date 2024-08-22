<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;
use App\Models\Province;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Mapel;
use App\Models\rfid;
use Illuminate\Support\Facades\Storage;
use App\Models\TahunPelajaran;
use Illuminate\View\View;

class DataIndukController extends Controller
{
    public function dataIndukStudent() : View {
        return view('akdemik.datainduk.student',[
            'title'=>'Data Peserta Didik',
            'students'=>student::orderBy('id', 'DESC')->with(['kota','kecamatan','desa'])->paginate(10),
            'provinsi'=>Province::all()
        ]);
    }
    public function dataIndukJurusan(){
        return view('akdemik.datainduk.jurusan',[
            'title'=>'Data Jurusan',
            'jurusans'=>jurusan::all(),

        ]);
    }
    public function dataIndukkelas(){
        return view('akdemik.datainduk.kelas',[
            'title'=>'Data Kelas',
            'kelas'=>Kelas::orderBy('id', 'DESC')->with('jurusanKelas')->get(),
            'jurusans'=>jurusan::where('status','1')->get()
        ]);
    }
    public function dataIndukMapel(){
        return view('akdemik.datainduk.mataPelajaran',[
            'title'=>'Data Mata Pelajaran',
            'mapel'=>Mapel::all()
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
            'nis' => 'required|min:10|unique:students',
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
        toastr()->success('Data Berhasil diSimpan');
        return redirect()->route('dataIndukStudent');

    }
    public function studentEditIndex($id){
        return view('akdemik.datainduk.students.editStudent',[
            'title'=>'Edit Data Peserta Didik',
            'students'=>student::where('id',decrypt($id))->get(),
            'provinsi'=>Province::all(),
            'rfid'=>rfid::all()
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
            'foto' => '',
            'id_rfid'=>''
        ]);

        if($request->file('foto')){
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validator['foto'] = $request->file('foto')->store('FotoProfile');
        }
        student::where('id',$request->id)->update($validator);
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();

    }
    public function dataIndukJurusanAdd(request $request){
        Jurusan::create([
            'nama_jurusan'=>$request->nama,
            'status'=>$request->status,

        ]);
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }

    public function dataIndukJurusanUpdate(request $request){
        jurusan::where('id',$request->id)->update([
            'nama_jurusan'=>$request->nama,
            'status'=>$request->status,
        ]);
        toastr()->success('Data Berhasil diubah');
        return redirect()->back();
    }
    public function dataIndukJurusanDelete($id){
        jurusan::where('id',$id)->delete();
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
