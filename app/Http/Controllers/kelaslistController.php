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

    public function kelaslistdetail(request $request,$id){
        $startDate = request('start');
        $endDate = request('end');

        if ($startDate && $endDate) {
            // Fetching the rombel with related data
            $cek = rombel::where('id_kelas', $id)
                ->with(['rombelStudent', 'rombelAbsentClass'])
                ->get();

            $nisList = []; // Store NIS numbers

            // Collect NIS numbers from absent class data
            foreach ($cek as $a) {
                foreach ($a->rombelAbsentClass as $absentClass) {
                    $nisList[] = $absentClass->nis;
                }
            }

            // Ensure NIS list is unique
            $nisList = array_unique($nisList);

            // Fetching absent data for the specified NIS within the date range
            $data = AbsentMapel::whereIn('nis', $nisList)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->get();
        } else {
            // If no date range is provided, fetch all students and their absences
            $data = rombel::where('id_kelas', $id)->where('id_kelas',$id)
                ->with(['rombelStudent', 'rombelAbsentClass'])
                ->get();
        }

        return view('datakelas.detail', [
            'title' => 'Detail Kelas',
            'students' => $data, // Ensure to return the right variable here
            'id' => $id
        ],compact('id'));
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
