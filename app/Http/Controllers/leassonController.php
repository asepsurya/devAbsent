<?php

namespace App\Http\Controllers;

use App\Models\gtk;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Lesson;
use App\Models\Jurusan;
use App\Models\ref_jadwal;
use App\Models\grupMapel;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class leassonController extends Controller
{
    public function index(){
        return view('datakelas.index',[
            'title'=>'Data Kelas',
            'kelas'=>Kelas::orderBy('id', 'DESC')->with(['jurusanKelas','jmlRombel'])->get(),
            'jurusans'=>Jurusan::where('status','1')->get()

        ]);
    }
    public function list($id){
        // get data berdasarkan tahun Ajaran
        if(request('tahun_ajar')){
            $jadwal = Lesson::where(['id_rombel'=>$id,'id_tahun_ajar'=>request('tahun_ajar')])->orderBy('day', 'ASC')->with(['mata_pelajaran','guru','ref'])->get();
        }else{
            $jadwal = Lesson::where('id_rombel',$id)->orderBy('day', 'ASC')->with(['mata_pelajaran','guru','ref'])->get();
        }
        // get data Kelas
        $cek = Kelas::where('id',$id)->with(['jurusanKelas'])->get();
        foreach($cek as $item){
            $kelas =  $item->nama_kelas.' '.$item->jurusanKelas->nama_jurusan.' '. $item->sub_kelas;
        }

        return view('jadwal.index',[
            'title' => 'Jadwal Pelajaran '.$kelas,
            'tahun_ajar'=>TahunPelajaran::where('status',1)->get(),
            'jadwal'=>$jadwal,
            'mapel' => grupMapel::where(['id_kelas'=> $id])->get(),
            'ref'=>ref_jadwal::where('status','1')->paginate('10')
        ],compact('id'));
    }

    public function getgtk(request $request){
        $data = grupMapel::where(['id_mapel'=> $request->mapel, 'id_kelas'=> $request->id_kelas])->get();
        foreach($data as $i){
            if($i->id_gtk == ''){
                $nama = 'BELUM DISETEL';
            }else{
                $nama = $i->guru->nama;
            }
            return [
                'a' => "<option value='$i->id_gtk'> $i->id_gtk </option>",
                'b'=> $nama];
        }
    }
    public function leassonAdd(request $request){
        $cek = Lesson::where([
            'day'=> $request->day,
            'id_mapel'=>$request->id_mapel,
            'id_gtk'=>$request->id_gtk,
            'id_tahun_ajar'=>$request->tahun_ajar])->get();
        if($cek->count() != 0){
            foreach($cek as $item){
                if($item->day == 1) {$hari = 'Senin';}
                elseif ($item->day == 2){ $hari ='Selasa';}
                elseif ($item->day == 3){ $hari ='Rabu';}
                elseif ($item->day == 4){ $hari ='Kamis';}
                elseif ($item->day == 5){ $hari ='Jumat';}
                elseif ($item->day == 6){ $hari ='Sabtu';}
                elseif ($item->day == 7){ $hari ='Minggu';}
            }

             Alert::info('Mata Pelajaranan Pada hari '.$hari.' Sudah terdaftar' );
             return redirect()->back();

        }else{
            if($request->type == "ref"){
                $id_mapel = $request->ref;
            }elseif($request->type == "mapel"){
                $id_mapel = $request->id_mapel;
            }
            Lesson::create([
                "day" => $request->day,
                "id_gtk" => $request->id_gtk,
                "status" => $request->status,
                "id_rombel" => $request->id_kelas,
                "start" => $request->start,
                "end" => $request->end,
                "no_sk" => $request->no_sk,
                "tgl_sk" => $request->tgl_sk,
                "id_tahun_ajar" => $request->tahun_ajar,
                "id_mapel" => $id_mapel
            ]);
            toastr()->success('Data Berhasil diubah');
            return redirect()->back();
        }

    }
    public function leassonDelete($id){
        Lesson::where('id',$id)->delete();
        toastr()->success('Data Berhasil dihapus');
            return redirect()->back();
    }

    public function leassonView($id){
        $cek = Kelas::where('id',$id)->with('jurusanKelas')->get();
        foreach($cek as $item){
            $kelas =  $item->nama_kelas.' '.$item->jurusanKelas->nama_jurusan.' '. $item->sub_kelas;
            $id_kelas = $id;
        }
        return view('jadwal.view',[
            'title'=>'Jadwal Pelajaran '.$kelas,
            'senin'=> Lesson::where(['day'=>'1','id_rombel'=>$id_kelas])->with(['mata_pelajaran','guru','ref'])->get(),
            'selasa'=> Lesson::where(['day'=>'2','id_rombel'=>$id_kelas])->with(['mata_pelajaran','guru','ref'])->get(),
            'rabu'=> Lesson::where(['day'=>'3','id_rombel'=>$id_kelas])->with(['mata_pelajaran','guru','ref'])->get(),
            'kamis'=> Lesson::where(['day'=>'4','id_rombel'=>$id_kelas])->with(['mata_pelajaran','guru','ref'])->get(),
            'jumat'=> Lesson::where(['day'=>'5','id_rombel'=>$id_kelas])->with(['mata_pelajaran','guru','ref'])->get(),
            'sabtu'=> Lesson::where(['day'=>'6','id_rombel'=>$id_kelas])->with(['mata_pelajaran','guru','ref'])->get(),

        ]);
    }
    public function reference(request $request){
        ref_jadwal::create([
            'ref'=>$request->ref,
            'ref_ID'=>mt_rand(),
            'status'=>'1'
        ]);
        toastr()->success('Data Berhasil ditambah');
        return redirect()->back()->with('ref', 5)->withInput();
    }
    public function referenceEdit(request $request){
        ref_jadwal::where('ref_ID',$request->ref_ID)->update([
            'ref'=>$request->ref
        ]);
        toastr()->success('Data Berhasil diubah');
        return redirect()->back()->with('ref', 5)->withInput();
    }
    public function referenceDelete($id){
        ref_jadwal::where('ref_ID',$id)->delete();
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back()->with('ref', 5)->withInput();
    }
}
