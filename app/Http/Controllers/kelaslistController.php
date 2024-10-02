<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\absent;
use App\Models\rombel;
use App\Models\Jurusan;
use App\Models\Mapel;
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

    public function kelaslistdetail(){
        return view('datakelas.detail',[
            'title'=>'Detail Kelas'
        ]);
    }

    public function absentclass(){

        return view('absensi.absentClass',[
            'title'=>'Absensi Kelas',
            'kelas'=>grupMapel::where('id_gtk', auth()->user()->nomor)->with(['kelas','kelas.jurusanKelas','kelas.jmlRombel','mata_pelajaran'])->get(),

        ]);
    }
    public function absentClassStudent(){
        $data =  rombel::where([
            'id_kelas'=>request('kelas'),
            ])->with(['rombelStudent','rombelAbsentClass'])->paginate(10)->appends(request()->query());
        //  Get Nama Rombel
         $cek = Kelas::where('id',request('kelas'))->with('jurusanKelas')->get();
         foreach($cek as $item){
             $kelas =  $item->nama_kelas.' '.$item->jurusanKelas->nama_jurusan.' '. $item->sub_kelas;
         }

         $mapel = Mapel::where('id',request('id_mapel'))->get('nama');
         foreach($mapel as $i){$getmapel = $i->nama;}
        return view('absensi.studentAbsent',[
            'title'=>'Absensi Siswa '.$kelas,
            'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
            'kelas'=>Kelas::where('status','1')->with('jurusanKelas')->get(),
            'rombel'=>$data,
            'mapel'=>$getmapel,
            'absent'=>absentMapel::where(['tanggal'=>request('tanggal'),'id_mapel'=>request('id_mapel'),'id_kelas'=>request('kelas')])->get(),

        ]);
    }
}
