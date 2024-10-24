<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\gtk;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\absent;
use App\Models\rombel;
use App\Models\Jurusan;
use App\Models\student;
use App\Models\grupMapel;
use App\Models\absentMapel;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;
use Illuminate\Routing\Controller;

class kelaslistController extends Controller
{
    public function kelaslist(){

        return view('datakelas.index',[
            'title'=> 'Data Kelas',
            'kelas'=>Kelas::orderBy('id', 'DESC')->with(['jurusanKelas','jmlRombel'])->get(),
        ]);
    }
    public function  kelaslistdetail(){

    }

    public function presensiClassStudent(request $request,$id){

        $data = rombel::where('id_kelas', $id)
                ->with(['rombelStudent', 'rombelAbsentClass'])
                ->get();
        $cekKelas = Kelas::where('id',$id)->get();
        foreach($cekKelas as $item){
            $kelas = $item->nama_kelas;
            $jurusan = $item->jurusanKelas->nama_jurusan;
            $subKelas = $item->sub_kelas;
            $created = $item->created_at;
        }
        return view('absensi.absensiKelas.presensiAbsent', [
            'title' => ''.$kelas.' '.$jurusan.' '.$subKelas,
            'students' => $data,
            'absent'=>absentMapel::where(['id_kelas'=>$id,'id_mapel'=>request('id_mapel')])->get(),
            'class_created'=>$created
        ],compact('id'));
    }

    public function absentclass(){
        return view('absensi.absentClass',[
            'title'=>'Absensi Kelas',
            'kelas'=>grupMapel::where('id_gtk', auth()->user()->nomor)->with(['kelas','kelas.jurusanKelas','kelas.jmlRombel','mata_pelajaran'])->get(),
        ]);
    }

    public function absentClassStudent(){
        $id = request('kelas');
        $data =  rombel::where([
            'id_kelas'=>request('kelas'),
            ])->with(['rombelStudent','rombelAbsentClass'])->paginate(10)->appends(request()->query());
        //  Get Nama Rombel
         $cek = Kelas::where('id',request('kelas'))->with('jurusanKelas')->get();
         foreach($cek as $item){
             $kelas =  $item->nama_kelas.' '.$item->jurusanKelas->nama_jurusan.' '. $item->sub_kelas;
             $created = $item->created_at;
        }

        $student = rombel::where('id_kelas', $id)
        ->with(['rombelStudent', 'rombelAbsentClass'])
        ->get();

         $mapel = Mapel::where('id',request('id_mapel'))->get('nama');
         foreach($mapel as $i){$getmapel = $i->nama;}
        return view('absensi.absensiKelas.studentAbsent',[
            'title'=>'Absensi Siswa '.$kelas,
            'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
            'kelas'=>Kelas::where('status','1')->with('jurusanKelas')->get(),
            'rombel'=>$data,
            'mapel'=>$getmapel,
            'students' => $student,
            'absent'=>absentMapel::where(['tanggal'=>request('tanggal'),'id_mapel'=>request('id_mapel'),'id_kelas'=>request('kelas')])->get(),
            'class_created'=>$created
        ],compact('id'));
    }

    public function absent_list($id_kelas,$nis){
        return view('daftarhadirKelas.listAbsent',[
            'title'=> 'Daftar Hadir',
            'mapel'=> grupMapel::where('id_kelas',$id_kelas)->with(['mata_pelajaran','guru','absent'])->get(),
            'hadir'=>absentMapel::where('id_kelas', $id_kelas)->where('nis', $nis)->get()
        ],compact('id_kelas','nis'));
    }

}
